Hola {{$user->name}}!

Gracias por registrarte en nuestra aplicación. Por favor, haz click en el siguiente enlace para verificar tu cuenta:

{{route('verify', $user->verification_token)}}