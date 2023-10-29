<?php

namespace App\Http\Controllers;

use App\Enums\UserAccessCourseStatusEnum;
use App\Enums\UserAccessCourseStatusPaymentEnum;
use App\Models\Order;
use App\Models\UserAccessCourse;
use Illuminate\Http\Request;
use Midtrans\Notification;
use App\Services\Midtrans\CallbackService;

class PaymentCallbackController extends Controller
{
    public function receive()
    {
        $callback = new CallbackService;

        if ($callback->isSignatureKeyVerified()) {
            $notification = $callback->getNotification();
            $order = $callback->getOrder();

            if ($callback->isSuccess()) {
                UserAccessCourse::where('id', $order->id)->update([
                    'payment_status' => UserAccessCourseStatusPaymentEnum::PAID,
                    'status' => UserAccessCourseStatusEnum::ACTIVE,
                    'payment_amount' => (int) str_replace('.00', '', $notification->gross_amount),
                ]);
            }

            if ($callback->isExpire()) {
                UserAccessCourse::where('id', $order->id)->update([
                    'payment_status' => UserAccessCourseStatusPaymentEnum::EXPIRED,
                    'status' => UserAccessCourseStatusEnum::UNPAID,
                ]);
            }

            if ($callback->isCancelled()) {
                UserAccessCourse::where('id', $order->id)->delete();
            }

            return response()
                ->json([
                    'success' => true,
                    'message' => 'Notifikasi berhasil diproses',
                ]);
        } else {
            return response()
                ->json([
                    'error' => true,
                    'message' => 'Signature key tidak terverifikasi',
                ], 403);
        }
    }
}
