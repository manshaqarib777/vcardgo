<div class="table-striped">
<livewire:vcard-gallery-table  :vcard-id="$vcard->id"/>
</div>
@include('vcards.gallery.templates.templates')
@include('vcards.gallery.create')
@include('vcards.gallery.edit')
@section('script')
<script>
    $('#editName').change(function() {
        if($(this).val() == "One")
            $('#editTicketFine').val("10$").change();
        if($(this).val() == "Two")
            $('#editTicketFine').val("20$").change();
        if($(this).val() == "Three")
            $('#editTicketFine').val("30$").change();
        if($(this).val() == "Four")
            $('#editTicketFine').val("40$").change();
        if($(this).val() == "Five")
            $('#editTicketFine').val("50$").change();
        if($(this).val() == "Six")
            $('#editTicketFine').val("60$").change();
        if($(this).val() == "Seven")
            $('#editTicketFine').val("70$").change();
        if($(this).val() == "Eight")
            $('#editTicketFine').val("80$").change();
        if($(this).val() == "Nine")
            $('#editTicketFine').val("90$").change();
        if($(this).val() == "Ten")
            $('#editTicketFine').val("100$").change();
    });
    $('#addName').change(function() {
        if($(this).val() == "One")
            $('#addTicketFine').val("10$").change();
        if($(this).val() == "Two")
            $('#addTicketFine').val("20$").change();
        if($(this).val() == "Three")
            $('#addTicketFine').val("30$").change();
        if($(this).val() == "Four")
            $('#addTicketFine').val("40$").change();
        if($(this).val() == "Five")
            $('#addTicketFine').val("50$").change();
        if($(this).val() == "Six")
            $('#addTicketFine').val("60$").change();
        if($(this).val() == "Seven")
            $('#addTicketFine').val("70$").change();
        if($(this).val() == "Eight")
            $('#addTicketFine').val("80$").change();
        if($(this).val() == "Nine")
            $('#addTicketFine').val("90$").change();
        if($(this).val() == "Ten")
            $('#addTicketFine').val("100$").change();
    });
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
