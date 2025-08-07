<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Payment;
use App\Models\Department;
use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentReminderMail;
use Carbon\Carbon;

class SendPaymentReminders extends Command
{
    protected $signature = 'payments:send-reminders';
    protected $description = 'Enviar recordatorios de pagos por vencer';

    public function handle()
    {
        info('⏰ Ejecutando el comando de recordatorios...');

    // Aquí puedes forzar un correo de prueba
    Mail::raw('Este es un correo de prueba enviado desde el cron.', function ($message) {
        $message->to('TU_CORREO@KPGroup.mx')
                ->subject('🧪 Prueba de Cron desde Laravel');
    });

    $this->info('Correo de prueba enviado.');
        $today = now();
        $targetDates = [
            $today->copy()->addMonth()->toDateString(),
            $today->copy()->addWeeks(2)->toDateString(),
            $today->copy()->addWeek()->toDateString(),
        ];

        $payments = Payment::whereIn('due_date', $targetDates)->get();
        $department = Department::where('name', 'Pagos')->first();

        if (!$department) {
            $this->error('Departamento Pagos no existe');
            return;
        }

        $recipients = $department->users;

        foreach ($payments as $payment) {
            foreach ($recipients as $user) {
                Mail::to($user->email)->send(new PaymentReminderMail($payment));
            }
        }

        $this->info('Recordatorios enviados.');
    }
}
