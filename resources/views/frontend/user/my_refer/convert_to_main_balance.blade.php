
<form action="{{ route('user.convert_to_main_balance') }}" method="post">
    @csrf
    <div class="form-group">
        <label>Convert Amount <span style="color: red">*</span> ( Minimum convert amount {{ get_settings('min_convert_amount').' '.base_currency_name() }})</label>
        <input type="number" class="form-control" min="{{ get_settings('min_convert_amount') }}" name="amount" id="amount" required>
    </div>


    <button class="btn btn-dark btn-rounded btn-icon-right mt-3" type="submit">Submit</button>
</form>
