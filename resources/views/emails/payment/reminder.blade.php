<x-mail::message>
# Recordatorio de Pago

**Servicio:** {{ $payment->service_name }}  
**Monto:** ${{ number_format($payment->amount, 2) }}  
**Vence el:** {{ \Carbon\Carbon::parse($payment->due_date)->format('d/m/Y') }}  
**Centro de costo:** {{ $payment->cost_center }}

<x-mail::button :url="''">
Ir al sistema
</x-mail::button>

Gracias,<br>
{{ config('app.name') }}
</x-mail::message>
