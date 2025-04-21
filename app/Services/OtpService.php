<?php

namespace App\Services;

use App\Mail\OtpMail;
use App\Repositories\Eloquent\OtpRepository;
use App\Repositories\Eloquent\UserRepository;
use Exception;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class OtpService
{
    protected $otpRepository;
    protected $userRepository;

    public function __construct(OtpRepository $otpRepository, UserRepository $userRepository)
    {
        $this->otpRepository = $otpRepository;
        $this->userRepository = $userRepository;
    }

    public function sendOtp($email)
    {
        try {
            $resend_time = 60; // thời gian gửi lại
            $validity_time = 600; // thời gian còn hiệu lực
            $otp = rand(100000, 999999);  // Sinh OTP ngẫu nhiên
            $expiresAt = now()->addSecond($validity_time);  // Thời gian hết hạn là 10 phút

            $otpResult = $this->otpRepository->create([
                'email' => $email,
                'otp' => $otp,
                'expires_at' => $expiresAt,
            ]);

            if (!$otpResult) {
                throw new Exception('Failed to create OTP in database');
            }

            Mail::to($email)->send(new OtpMail($otpResult->otp));

            return [
                'message' => 'OTP đã được gửi thành công',
                'timers' => [
                    "resend" => [
                        "remains" => $resend_time,
                        "until" => $expiresAt->toDateTimeString(),
                    ],
                    "validity" => [
                        "remains" => $validity_time,
                        "until" => $expiresAt->toDateTimeString(),
                    ],
                ]
            ];
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function verifyOtp(array $data): array
    {
        try {
            $otpResult = $this->otpRepository->validateOtp([
                'email' => $data['email'],
                'otp' => $data['otp'],
            ]);

            if (!$otpResult) {
                return [
                    'is_warning' => true,
                    'message' => 'OTP không hợp lệ',
                    'code' => 401,
                ];
            }

            return [
                'message' => 'đã xác minh OTP thành công',
            ];
        } catch (Exception $e) {
            throw $e;
        }
    }
}
