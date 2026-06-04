@component('mail::message')
# New Remote Sales Application

A new application has been submitted from the landing page.

@component('mail::panel')
**Application ID:** {{ $application->id }}

**Telegram:** {{ $application->telegram_username }}

**English Level:** {{ $application->english_level }}

**Submitted At:** {{ $application->created_at?->format('Y-m-d H:i') }}
@endcomponent

## Sales Experience

{{ $application->sales_experience }}

@component('mail::button', ['url' => url('/admin/remote-sales-applications/' . $application->id)])
Open in Admin Panel
@endcomponent

## Technical Details

**IP Address:** {{ $application->ip_address ?? 'N/A' }}

**User Agent:** {{ $application->user_agent ?? 'N/A' }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
