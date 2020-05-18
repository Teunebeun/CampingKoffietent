<div class="mail">
<img src="{{ $path_to_logo }}" class="email">
<h1>Camping Koffietent</h1>
<hr style="width: 60%; margin-bottom: 30px"/>
<p>
Beste {{ $user->name }}, klik op de onderstaande knop om je wachtwoord opnieuw in te stellen!
</p>
<p>
Groet, <br/> Team Camping Koffietent
</p>
<form METHOD="GET" action="{{route('password.reset', $token)}}" class="email">
    <input type="submit" value="Wijzig wachtwoord!" class="email"/>
</form>
</div>




