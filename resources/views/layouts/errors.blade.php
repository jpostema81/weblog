@if (Session::get('flash_message'))

    <div class="notification is-info">
        <strong>{{ session('flash_message') }}</strong>
    </div>

@endif