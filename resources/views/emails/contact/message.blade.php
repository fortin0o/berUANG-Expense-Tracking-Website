<x-mail::message>
# New Contact Message

You have received a new contact message from **berUANG**.

**Name:** {{ $messageData->name }}  
**Email:** {{ $messageData->email }}

**Message:**  
{{ $messageData->message }}

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>

