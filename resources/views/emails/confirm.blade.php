Hola {{$user->name}}!

Has cambiado tu correo electronico. Por favor, verifica la nueva dirección en el siguiente enlace:

{{route('verify', $user->verification_token)}}