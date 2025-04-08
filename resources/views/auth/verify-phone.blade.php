@extends('layouts.app')
@section('content')
    <style>
        body {
            background: #f8f9fa;
        }

        .verify-card {
            max-width: 500px;
            margin: 10vh auto auto;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
            background-color: #fff;
            text-align: center;
        }

        .verify-card h4 {
            font-weight: bold;
            color: #333;
        }

        .verify-card input {
            border-radius: 8px;
        }

        .verify-card .btn {
            border-radius: 8px;
        }

        #timer {
            font-weight: bold;
            color: #dc3545;
        }
    </style>

    <div class="container">
        <div class="verify-card">
            <h4 class="mb-3">تأكيد رقم الهاتف</h4>
            <p class="text-muted">يرجى إدخال رقم هاتفك لتلقي رمز التحقق عبر واتساب.</p>
            @php
                $phone = \Illuminate\Support\Facades\Auth::user()->phone ? \Illuminate\Support\Facades\Auth::user()->phone : '';
            @endphp
            <div class="mb-3">
                <input type="text" id="phone" value="{{ $phone }}" class="form-control text-center"
                       placeholder="مثال: 249912345678">
            </div>

            <button id="sendCodeBtn" class="btn btn-primary w-100">تأكيد</button>

            <a id="whatsappBtn" href="#" target="_blank" class="btn btn-success w-100 mt-2 d-none">
                <span class="fab fa-whatsapp"></span> إضغط هنا للتحقق عبر واتساب
            </a>

            <button id="resendBtn" class="btn btn-outline-secondary w-100 mt-2 d-none">🔁 إعادة إرسال الرمز</button>

            <div id="timer" class="mt-3 d-none">الوقت المتبقي: 2:00</div>
            <div id="status" class="mt-2 text-muted small"></div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const apiTokenUrl = 'https://aywa.sd/otp/TokenHandler.php';
        const apiVerifyUrl = 'https://aywa.sd/otp/UserVerificationCheck.php';

        let verificationInterval;
        let countdownInterval;

        function startTimer() {
            let seconds = 120;
            const timer = document.getElementById('timer');
            timer.classList.remove('d-none');

            countdownInterval = setInterval(() => {
                let min = Math.floor(seconds / 60);
                let sec = seconds % 60;
                timer.innerText = `الوقت المتبقي: ${min}:${sec < 10 ? '0' + sec : sec}`;
                seconds--;

                if (seconds < 0) {
                    clearInterval(countdownInterval);
                    clearInterval(verificationInterval);
                    document.getElementById('status').innerText = 'انتهى الوقت! يرجى إعادة المحاولة.';

                    // إظهار زر إعادة الإرسال
                    document.getElementById('resendBtn').classList.remove('d-none');
                    document.getElementById('sendCodeBtn').classList.remove('d-none');
                    document.getElementById('sendCodeBtn').disabled = false;
                    document.getElementById('sendCodeBtn').innerText = 'تأكيد';
                }
            }, 1000);
        }

        document.getElementById('sendCodeBtn').addEventListener('click', function () {
            const phone = document.getElementById('phone').value.trim();
            if (!phone) return alert('يرجى إدخال رقم الهاتف');

            this.disabled = true;
            this.innerText = 'جاري الإرسال...';
            document.getElementById('status').innerText = '';
            document.getElementById('resendBtn').classList.add('d-none');
            document.getElementById('whatsappBtn').classList.add('d-none');

            fetch(apiTokenUrl, {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({phone})
            })
                .then(res => res.json())
                .then(data => {
                    if (data.token) {
                        const waBtn = document.getElementById('whatsappBtn');
                        waBtn.href = `https://wa.me/249912479796?text=OTP:${data.token}`;
                        waBtn.classList.remove('d-none');

                        document.getElementById('sendCodeBtn').style.display = 'none';
                        document.getElementById('status').innerText = '✅ تم إرسال الرمز. جارٍ التحقق...';

                        startTimer();

                        verificationInterval = setInterval(() => {
                            fetch(apiVerifyUrl, {
                                method: 'POST',
                                headers: {'Content-Type': 'application/json'},
                                body: JSON.stringify({phone})
                            })
                                .then(res => res.json())
                                .then(response => {
                                    if (response.verified === 1) {
                                        clearInterval(verificationInterval);
                                        clearInterval(countdownInterval);
                                        document.getElementById('status').innerText = '✅ تم التحقق بنجاح. سيتم تحويلك...';

                                        fetch('{{ route("phone.verify.success") }}', {
                                            method: "POST",
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                            },
                                            body: JSON.stringify({phone})
                                        }).then(() => {
                                            setTimeout(() => {
                                                window.location.href = '{{ route("home") }}';
                                            }, 1500);
                                        });
                                    }
                                });
                        }, 1000);
                    } else {
                        document.getElementById('status').innerText = 'فشل في إرسال الرمز، حاول مجددًا.';
                        document.getElementById('sendCodeBtn').disabled = false;
                        document.getElementById('sendCodeBtn').innerText = 'تأكيد';
                    }
                })
                .catch(() => {
                    document.getElementById('status').innerText = 'حدث خطأ، حاول لاحقًا.';
                    document.getElementById('sendCodeBtn').disabled = false;
                    document.getElementById('sendCodeBtn').innerText = 'تأكيد';
                });
        });

        // إعادة الإرسال عند الضغط
        document.getElementById('resendBtn').addEventListener('click', function () {
            this.classList.add('d-none');
            document.getElementById('sendCodeBtn').style.display = 'block';
            document.getElementById('sendCodeBtn').click();
        });
    </script>
@endsection
