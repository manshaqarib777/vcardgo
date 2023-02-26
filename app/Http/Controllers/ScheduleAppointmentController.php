<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Vcard;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Mail\AppointmentMail;
use App\Mail\UserAppointmentMail;
use App\Models\AppointmentDetail;
use Illuminate\Support\Facades\DB;
use App\Models\ScheduleAppointment;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\PaypalController;
use App\Http\Controllers\AppBaseController;
use App\Repositories\AppointmentRepository;
use Illuminate\Contracts\Foundation\Application;
use App\Http\Requests\CreateScheduleAppointmentRequest;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class ScheduleAppointmentController extends AppBaseController
{
    public function __construct()
    {
        $this->middleware('permission:user-appointments.index', ['only' => ['appointmentsList']]);
        $this->middleware('permission:user-appointments.calender', ['only' => ['appointmentCalendar']]);
    }
    /**
     * @param CreateScheduleAppointmentRequest $request
     *
     * @return mixed
     */
    public function store(CreateScheduleAppointmentRequest $request)
    {

        $input = $request->all();

        try {
            DB::beginTransaction();
            $vcard = Vcard::with('tenant.user')->where('id', $input['vcard_id'])->first();
            $input['toName'] = auth()->user()->fullName;
            $input['vcard_name'] = auth()->user()->fullName;
            $userId = auth()->id();

            //Stripe
            if (isset($input['payment_method'])) {
                if ($input['payment_method'] == Appointment::STRIPE) {
                    /** @var AppointmentRepository $repo */
                    $repo = App::make(AppointmentRepository::class);

                    $result = $repo->userCreateSession($userId, $vcard, $input);

                    DB::commit();

                    return $this->sendResponse([
                        'payment_method' => $input['payment_method'],
                        $result,
                    ], 'Stripe session created successfully.');
                }

                //PayPal
                if ($input['payment_method'] == Appointment::PAYPAL) {
                    /** @var PaypalController $payPalCont */
                    $payPalCont = App::make(PaypalController::class);

                    $result = $payPalCont->userOnBoard($userId, $vcard, $input);

                    DB::commit();

                    return $this->sendResponse([
                        'payment_method' => $input['payment_method'],
                        $result,
                    ], 'Paypal session created successfully.');
                }
            }

            /** @var AppointmentRepository $appointmentRepo */
            $appointmentRepo = App::make(AppointmentRepository::class);
            $vcardEmail = auth()->user()->email;
            $appointmentRepo->appointmentStoreOrEmail($input, $vcardEmail);

            DB::commit();

            return $this->sendSuccess('Appointment created successfully.');
        } catch (Exception $e) {
            DB::rollBack();

            return $this->sendError($e->getMessage());
        }
    }

    /**
     *
     * @return Application|Factory|View
     */
    public function appointmentsList()
    {

        return view('appointment.list');
    }

    /**
     *
     * @return Application|Factory|View
     */
    public function galleriesList()
    {

        return view('appointment.gallery.index');
    }

    /**
     *
     * @return Application|Factory|View
     */
    public function appointmentsScheduleList()
    {
        $appointmentHours = Auth::user()->appointmentHours()->get()->groupBy('day_of_week');

        foreach ($appointmentHours as $day => $hours) {
            foreach ($hours as $hour) {
                $data['time'][$day][] = [
                    'start_time' => $hour->start_time,
                    'end_time'   => $hour->end_time,
                ];
            }
        }
        return view('appointment.appointment-schedule')->with($data);
    }

    /**
     * @param Request $request
     *
     *
     * @return Application|Factory|View
     */
    public function appointmentCalendar(Request $request)
    {
        if ($request->ajax()) {
            $input = $request->all();
            $data = $this->getCalendar();

            return $this->sendResponse($data, 'Appointment calendar data retrieved successfully.');
        }

        return view('appointment.appointment-calendar');
    }

    /**
     *
     * @return array
     */
    public function getCalendar()
    {
        /** @var ScheduleAppointment $appointment */
        $appointments = ScheduleAppointment::whereHas('vcard', function ($q) {
            $q->where('tenant_id', getLogInTenantId());
        })->get();

        $data = [];
        $count = 0;
        foreach ($appointments as $key => $appointment) {
            $startTime = $appointment->from_time;
            $endTime = $appointment->to_time;
            $start = Carbon::createFromFormat('Y-m-d h:i A',
                date('Y-m-d', strtotime($appointment->date)).' '.$startTime);
            $end = Carbon::createFromFormat('Y-m-d h:i A', date('Y-m-d', strtotime($appointment->date)).' '.$endTime);
            $data[$key]['id'] = $appointment->id;
            $data[$key]['title'] = $startTime.'-'.$endTime;
            $data[$key]['name'] = $appointment->name;
            $data[$key]['email'] = $appointment->email;
            $data[$key]['reason'] = $appointment->reason;
            $data[$key]['location'] = $appointment->location;
            $data[$key]['message'] = $appointment->message;
            $data[$key]['phone'] = is_null($appointment->phone) ? 'N/A' : $appointment->phone;
            $data[$key]['vcardName'] = $appointment->vcard->name;
            $data[$key]['start'] = $start->toDateTimeString();
            $data[$key]['startDateTime'] = $start->format('jS M, Y - h:i A');
            $data[$key]['description'] = $appointment->vcard->description;
            $data[$key]['status'] = $appointment->vcard->status;
            $data[$key]['end'] = $end->toDateTimeString();
            $data[$key]['endDateTime'] = $end->format('jS M, Y - h:i A');
            $data[$key]['color'] = '#FFF';
            $data[$key]['className'] = [getStatusClassName($appointment->vcard->status),];
        }

        return $data;
    }



    /**
     * @param $id
     *
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        $appointment = ScheduleAppointment::with('vcard')->where('id', '=', $id)->first();
        return $this->sendResponse($appointment, 'Appointment successfully retrieved.');
    }

    /**
     * @param $id
     *
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $appointment = ScheduleAppointment::where('id', $id)->first();
        $appointment->delete();

        return $this->sendSuccess('Appointment deleted successfully.');
    }

    /**
     * @param  UpdateProductRequest  $request
     * @param $id
     *
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $appointment = ScheduleAppointment::findOrFail($id);
        $appointment->update($input);

        return $this->sendSuccess('Appointment updated successfully.');
    }

    public function updateAppointmentsSchedule(Request $request, $id)
    {
        try {
            $input = $request->all();

            Appointment::whereVcardId($id)->delete();
            if (isset($input['checked_week_days'])) {
                foreach ($input['checked_week_days'] as $day) {
                    $this->saveSlots($input, $day, $id);
                }
            }

            $appointmentDetails = AppointmentDetail::where('vcard_id', $id)->first();
            if (isset($input['is_paid'])) {
                if (!empty($appointmentDetails)) {
                    $appointmentDetails->update([
                        'is_paid' => $input['is_paid'],
                        'price'   => $input['price'],
                    ]);
                } else {
                    AppointmentDetail::create([
                        'vcard_id' => $id,
                        'is_paid'  => $input['is_paid'],
                        'price'    => $input['price'],
                    ]);
                }
            }
        } catch (Exception $e) {
            DB::rollBack();

            throw new UnprocessableEntityHttpException($e->getMessage());
        }
        Session::flash('success', ' '.__('messages.flash.vcard_update'));

        return redirect()->back();
    }
    public function saveSlots($input, $day, $id)
    {
        $startTimeArr = $input['startTimes'][$day] ?? [];
        $endTimeArr = $input['endTimes'][$day] ?? [];
        if (count($startTimeArr) != 0 && count($endTimeArr) != 0) {
            foreach (array_unique($startTimeArr) as $key => $startTime) {
                Appointment::create([
                    'vcard_id'    => $id,
                    'day_of_week' => $day,
                    'start_time'  => $startTime,
                    'end_time'    => $endTimeArr[$key],
                ]);
            }
        }

        return true;
    }
}
