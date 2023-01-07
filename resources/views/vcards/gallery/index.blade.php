<div class="table-striped">
<livewire:vcard-gallery-table  :vcard-id="$vcard->id"/>
</div>
@include('vcards.gallery.templates.templates')
@include('vcards.gallery.create')
@include('vcards.gallery.edit')
@section('script')
<script>
    $('#editFine').change(function() {
        if($(this).val() == "Not Suspended")
        {
            $('.editSuspended').hide()
        }
        else
        {
            $('.editSuspended').show()
        }
    });
    $('#addFine').change(function() {
        if($(this).val() == "Not Suspended")
        {
            $('.addSuspended').hide()
        }
        else
        {
            $('.addSuspended').show()
        }
    });
</script>
@endsection
