
<form method="POST" action="{{ route('password.update') }}">
    @csrf
    {{-- <input type="hidden" name="token" value="{{ $token }}"> --}}
    <input type="text" name="token" value="{{ $token }}">
    <label>
        Email
        <input type="email" name="email" required  value="{{ $email }}"/>
    </label>
    <label>
        Nueva clave
        <input type="password" name="password" required />
    </label>
    <label>
        Confirmar clave
        <input type="password" name="password_confirmation" required />
    </label>
    <input type="submit" value="Resetear clave" />
</form>