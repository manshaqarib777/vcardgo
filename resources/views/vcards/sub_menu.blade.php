<ul class="nav nav-tabs mb-sm-7 mb-5 pb-1 flex-nowrap text-nowrap">
    <li class="nav-item position-relative me-7 mb-3">
        <a class="nav-link p-0  {{(isset($partName) && $partName == 'basics') ? 'active' : ''}}"
           href="{{route('vcards.edit',$vcard->id).'?part=basics'}}">
            {{ __('messages.vcard.basic_details') }}
        </a>
    </li>
    <li class="nav-item position-relative me-7 mb-3">
        <a class="nav-link p-0 {{(isset($partName) && $partName == 'templates') ? 'active' : ''}}"
           href="{{route('vcards.edit',$vcard->id).'?part=templates'}}">
            {{ __('messages.vcard.template') }}
        </a>
    </li>
    <li class="nav-item position-relative me-7 mb-3">
        <a class="nav-link p-0 {{(isset($partName) && $partName == 'business_hours') ? 'active' : ''}}"
           href="{{route('vcards.edit',$vcard->id).'?part=business_hours'}}">
            {{ __('messages.business.business_hours') }}
        </a>
    </li>
    @if(checkFeature('services'))
        <li class="nav-item position-relative me-7 mb-3">
        <a class="nav-link p-0 {{(isset($partName) && $partName == 'services') ? 'active' : ''}}"
           href="{{route('vcards.edit',$vcard->id).'?part=services'}}">
            {{ __('messages.vcard.services') }}
        </a>
    </li>
    @endif
    @if(checkFeature('products'))
        <li class="nav-item position-relative me-7 mb-3">
            <a class="nav-link p-0 {{(isset($partName) && $partName == 'products') ? 'active' : ''}}"
               href="{{route('vcards.edit',$vcard->id).'?part=products'}}">
                {{ __('messages.vcard.products') }}
            </a>
        </li>
    @endif
    @if(checkFeature('testimonials'))
        <li class="nav-item position-relative me-7 mb-3">
        <a class="nav-link p-0 {{(isset($partName) && $partName == 'testimonials') ? 'active' : ''}}"
           href="{{route('vcards.edit',$vcard->id).'?part=testimonials'}}">
            {{ __('messages.vcard.testimonials') }}
        </a>
    </li>
    @endif
    @if(checkFeature('appointments'))
        <li class="nav-item position-relative me-7 mb-3">
            <a class="nav-link p-0 {{(isset($partName) && $partName == 'appointments') ? 'active' : ''}}"
               href="{{route('vcards.edit',$vcard->id).'?part=appointments'}}">
                {{ __('messages.vcard.appointments') }}
            </a>
        </li>
    @endif
    @if(checkFeature('social_links'))
        <li class="nav-item position-relative me-7 mb-3">
            <a class="nav-link p-0 {{(isset($partName) && $partName == 'social_links') ? 'active' : ''}}"
               href="{{route('vcards.edit',$vcard->id).'?part=social_links'}}">
                {{ __('messages.social.social_links') }}
            </a>
        </li>
    @endif
    @if(planfeaturecount() >= 6)

        <li class="nav-item position-relative me-7 mb-3">
            <div class="dropdown d-flex align-items-center">
                <a class="btn ps-2 pt-0 pe-0" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fs-3"></i>
                </a>
                <div class="dropdown-menu pb-4 my-2" aria-labelledby="dropdownMenuButton1">
                    <ul>
                        @if(checkFeature('advanced'))

                        <li>
                                <a class="dropdown-item text-gray-900 {{(isset($partName) && $partName == 'advanced') ? 'active' : ''}}"
                                   href="{{route('vcards.edit',$vcard->id).'?part=advanced'}}" style="font-size: 15px">
                                    {{ __('messages.vcard.advanced') }}
                                </a>
                        </li>
                        @endif
                        @if(checkFeature('custom_fonts'))

                        <li>
                                <a class="dropdown-item text-gray-900 {{(isset($partName) && $partName == 'custom_fonts') ? 'active' : ''}}"
                                   href="{{route('vcards.edit',$vcard->id).'?part=custom_fonts'}}" style="font-size: 15px">
                                    {{ __('messages.font.fonts') }}
                                </a>
                        </li>
                        @endif

                        @if(checkFeature('gallery'))
                        <li>
                                <a class="dropdown-item text-gray-900 {{(isset($partName) && $partName == 'galleries') ? 'active' : ''}}"
                                   href="{{route('vcards.edit',$vcard->id).'?part=galleries'}}" style="font-size: 15px">
                                    {{ __('messages.gallery.gallery_name') }}
                                </a>
                        </li>
                        @endif
                        @if(checkFeature('seo'))
                        <li>
                                <a class="dropdown-item text-gray-900  {{(isset($partName) && $partName == 'seo') ? 'active' : ''}}"
                                   href="{{route('vcards.edit',$vcard->id).'?part=seo'}}" style="font-size: 15px">
                                    {{ __('messages.plan.seo') }}
                                </a>
                        </li>
                        @endif
                        @if(checkFeature('blog'))
                        <li>
                                <a class="dropdown-item text-gray-900  {{(isset($partName) && $partName == 'blogs') ? 'active' : ''}}"
                                   href="{{route('vcards.edit',$vcard->id).'?part=blogs'}}" style="font-size: 15px">
                                    {{ __('messages.plan.blog') }}
                                </a>
                        </li>
                        @endif
                        @if(checkFeature('registration_custom_idea'))
                        <li>
                                <a class="dropdown-item text-gray-900  {{(isset($partName) && $partName == 'registration_custom_idea') ? 'active' : ''}}"
                                   href="{{route('vcards.edit',$vcard->id).'?part=registration_custom_idea'}}" style="font-size: 15px">
                                    {{ __('messages.vcard.registration_custom_idea') }}
                                </a>
                        </li>
                        @endif
                        @if(checkFeature('inspection_custom_idea'))
                        <li>
                                <a class="dropdown-item text-gray-900  {{(isset($partName) && $partName == 'inspection_custom_idea') ? 'active' : ''}}"
                                   href="{{route('vcards.edit',$vcard->id).'?part=inspection_custom_idea'}}" style="font-size: 15px">
                                    {{ __('messages.vcard.inspection_custom_idea') }}
                                </a>
                        </li>
                        @endif
                        @if(checkFeature('parking_custom_idea'))
                        <li>
                                <a class="dropdown-item text-gray-900  {{(isset($partName) && $partName == 'parking_custom_idea') ? 'active' : ''}}"
                                   href="{{route('vcards.edit',$vcard->id).'?part=parking_custom_idea'}}" style="font-size: 15px">
                                    {{ __('messages.vcard.parking_custom_idea') }}
                                </a>
                        </li>
                        @endif
                        <li>
                            <a class="dropdown-item text-gray-900  {{(isset($partName) && $partName == 'privacy_policy') ? 'active' : ''}}"
                               href="{{route('vcards.edit',$vcard->id).'?part=privacy_policy'}}"
                               style="font-size: 15px">
                                {{ __('messages.setting.privacy&policy') }}
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item text-gray-900  {{(isset($partName) && $partName == 'term_condition') ? 'active' : ''}}"
                               href="{{route('vcards.edit',$vcard->id).'?part=term_condition'}}"
                               style="font-size: 15px">
                                {{ __('messages.vcard.term_condition') }}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </li>

    @else
        @if(checkFeature('advanced'))
            <li class="nav-item position-relative me-7 mb-3">
                <a class="nav-link p-0  {{(isset($partName) && $partName == 'advanced') ? 'active' : ''}}"
                   href="{{route('vcards.edit',$vcard->id).'?part=advanced'}}" style="font-size: 15px">
                    {{ __('messages.vcard.advanced') }}
                </a>
            </li>
        @endif
        @if(checkFeature('custom_fonts'))
                <li class="nav-item position-relative me-7 mb-3">
                <a class="nav-link p-0  {{(isset($partName) && $partName == 'custom_fonts') ? 'active' : ''}}"
                   href="{{route('vcards.edit',$vcard->id).'?part=custom_fonts'}}" style="font-size: 15px">
                    {{ __('messages.font.fonts') }}
                </a>
            </li>
        @endif
        @if(checkFeature('gallery'))
                <li class="nav-item position-relative me-7 mb-3">
                <a class="nav-link p-0  {{(isset($partName) && $partName == 'gallery') ? 'active' : ''}}"
                   href="{{route('vcards.edit',$vcard->id).'?part=gallery'}}" style="font-size: 15px">
                    {{ __('messages.gallery.gallery_name') }}
                </a>
            </li>
        @endif
        @if(checkFeature('seo'))
            <li class="nav-item position-relative me-7 mb-3">
                <a class="nav-link p-0  {{(isset($partName) && $partName == 'seo') ? 'active' : ''}}"
                    href="{{route('vcards.edit',$vcard->id).'?part=seo'}}" style="font-size: 15px">
                    {{ __('messages.plan.seo') }}
                </a>
            </li>
        @endif
        @if(checkFeature('registration_custom_idea'))
            <li class="nav-item position-relative me-7 mb-3">
                <a class="nav-link p-0  {{(isset($partName) && $partName == 'registration_custom_idea') ? 'active' : ''}}"
                href="{{route('vcards.edit',$vcard->id).'?part=registration_custom_idea'}}" style="font-size: 15px">
                    {{ __('messages.vcard.registration_custom_idea') }}
                </a>
            </li>
        @endif
        @if(checkFeature('inspection_custom_idea'))
            <li class="nav-item position-relative me-7 mb-3">
                <a class="nav-link p-0  {{(isset($partName) && $partName == 'inspection_custom_idea') ? 'active' : ''}}"
                href="{{route('vcards.edit',$vcard->id).'?part=inspection_custom_idea'}}" style="font-size: 15px">
                    {{ __('messages.vcard.inspection_custom_idea') }}
                </a>
            </li>
        @endif
        @if(checkFeature('parking_custom_idea'))
            <li class="nav-item position-relative me-7 mb-3">
                <a class="nav-link p-0  {{(isset($partName) && $partName == 'parking_custom_idea') ? 'active' : ''}}"
                href="{{route('vcards.edit',$vcard->id).'?part=parking_custom_idea'}}" style="font-size: 15px">
                    {{ __('messages.vcard.parking_custom_idea') }}
                </a>
            </li>
        @endif
        @if(checkFeature('blog'))
            <li class="nav-item position-relative me-7 mb-3">
                <a class="nav-link p-0  {{(isset($partName) && $partName == 'blog') ? 'active' : ''}}"
                    href="{{route('vcards.edit',$vcard->id).'?part=blog'}}" style="font-size: 15px">
                    {{ __('messages.plan.blog') }}
                </a>
            </li>
        @endif

        <li class="nav-item position-relative me-7 mb-3">
            <a class="nav-link p-0  {{(isset($partName) && $partName == 'privacy_policy') ? 'active' : ''}}"
                href="{{route('vcards.edit',$vcard->id).'?part=privacy_policy'}}" style="font-size: 15px">
                {{ __('messages.setting.privacy&policy') }}
            </a>
        </li>

        <li class="nav-item position-relative me-7 mb-3">
            <a class="nav-link p-0  {{(isset($partName) && $partName == 'term_condition') ? 'active' : ''}}"
                href="{{route('vcards.edit',$vcard->id).'?part=term_condition'}}" style="font-size: 15px">
                {{ __('messages.vcard.term_condition') }}
            </a>
        </li>


    @endif

</ul>
