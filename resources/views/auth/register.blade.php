@extends('layouts.app')
@section('content')
    <style type="text/css">
        #navbar {
            display: none;
        }


        body {
            background: #fff !important;
        }

    </style>
    <div class="container p-0">
        <div class="col-12 p-0 row d-flex">
            <div class="col-12 col-lg-6 text-center p-0" style="">
                <div class="col-12 p-2 p-lg-4 align-items-center justify-content-center d-flex row"
                     style="min-height:70vh">
                    <div class="col-12 p-3 p-lg-4" style="background:#fff;border-radius: 10px;">
                        <form method="POST" action="{{ route('register') }}" id="register-form" class="row m-0 d-flex">
                            @csrf
                            <input type="hidden" name="recaptcha" id="recaptcha">
                            <div class="col-12 p-0 mb-5 mt-3" style="width: 550px;max-width: 100%;margin: 0px auto;">
                                <h3 class="mb-4 font-4">{{ __('lang.register') }}</h3>
                            </div>

                            @if(env('GOOGLE_CLIENT_ID')!=null)
                                <div class="col-6 py-2 px-2">
                                    <div class="col-12 p-0">
                                        <a href="/login/google/redirect"
                                           style="border:2px solid #51c75b;color:inherit;box-shadow: 0px 6px 10px rgb(52 52 52 / 12%);"
                                           class="col-12 d-flex p-3 align-items-center justify-content-center btn">
                                            دخول عبر <img src="/images/icons/google.png" style="width:30px"
                                                          class="mx-2"/>
                                        </a>
                                    </div>
                                </div>
                            @endif
                            @if(env('FACEBOOK_CLIENT_ID')!=null)
                                <div class="col-6 py-2 px-2">
                                    <div class="col-12 p-0">
                                        <a href="/login/facebook/redirect"
                                           style="border:2px solid #3f71cd;color:inherit;box-shadow: 0px 6px 10px rgb(52 52 52 / 12%);background: #3f71cd;color:#fff"
                                           class="col-12 d-flex p-3 align-items-center justify-content-center btn">
                                            دخول عبر <span class="fab fa-facebook-f mx-2" style="color:#fff"></span>
                                        </a>
                                    </div>
                                </div>
                            @endif

                            <div class="nafezly-divider-right"
                                 style="    background-image: linear-gradient( 90deg,transparent,rgb(0 0 0/72%));right: auto;left: 10px;opacity: .1;margin: 14px 0;min-height: 2px;"></div>


                            <div class="form-group row mb-4 col-12 col-lg-6   px-0 pt-2 ">
                                <div class="col-md-12 px-2 pt-4" style="position: relative;">
                                    <label for="name"
                                           class="col-form-label text-md-right mb-1 font-small px-2 py-1 d-inline"
                                           style="background:#f4f4f4;position: absolute;top: 17px;right: 20px; border-radius: 3px!important">الأسم رباعي</label>
                                    <input id="name" type="text"
                                           class="form-control mt-2 d-inline-block @error('name') is-invalid @enderror"
                                           name="name" value="" required="" autocomplete="off" autofocus=""
                                           style=";height: 42px;border-color: #eaedf1;border-radius: 3px!important"
                                           value="{{ old('name') }}">
                                </div>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                @enderror
                            </div>
                            <div class="form-group row mb-4 col-12 col-lg-6   px-0 pt-2 ">
                                <div class="col-md-12 px-2 pt-4" style="position: relative;">
                                    <label for="email"
                                           class="col-form-label text-md-right mb-1 font-small px-2 py-1 d-inline"
                                           style="background:#f4f4f4;position: absolute;top: 17px;right: 20px; border-radius: 3px!important">البريد الالكتروني (سيتم إرسال رسالة تحقق)</label>
                                    <input id="email" type="email"
                                           class="form-control mt-2 d-inline-block @error('email') is-invalid @enderror"
                                           name="email" required="" autocomplete="off" autofocus=""
                                           style=";height: 42px;border-color: #eaedf1;border-radius: 3px!important"
                                           value="{{ old('email') }}">
                                </div>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                @enderror
                            </div>
                            <div class="form-group row mb-4 col-12 col-lg-12 px-0 pt-2">
                                <div class="col-md-12 px-2 pt-4" style="position: relative;">
                                    <label for="phone"
                                           class="col-form-label text-md-right mb-1 font-small px-2 py-1 d-inline"
                                           style="background:#f4f4f4;position: absolute;top: 17px;right: 20px; border-radius: 3px!important">
                                        رقم الواتساب بالمفتاح
                                    </label>

                                    <div class="input-group mt-4" style="height: 42px;">
                                        <div class="input-group-prepend">
                                            <select id="country_code" class="form-control select2" name="country_code"
                                                    style="min-width: 100px; border-radius: 3px 0 0 3px !important; height: 100%;">
                                                <option value="93">أفغانستان</option>
                                                <option value="355">ألبانيا</option>
                                                <option value="213">الجزائر</option>
                                                <option value="1684">ساموا الأمريكية</option>
                                                <option value="376">أندورا</option>
                                                <option value="244">أنغولا</option>
                                                <option value="1264">أنغيلا</option>
                                                <option value="672">القارة القطبية الجنوبية</option>
                                                <option value="1268">أنتيغوا وبربودا</option>
                                                <option value="54">الأرجنتين</option>
                                                <option value="374">أرمينيا</option>
                                                <option value="297">أروبا</option>
                                                <option value="61">أستراليا</option>
                                                <option value="43">النمسا</option>
                                                <option value="994">أذربيجان</option>
                                                <option value="1242">جزر البهاما</option>
                                                <option value="973">البحرين</option>
                                                <option value="880">بنغلاديش</option>
                                                <option value="1246">بربادوس</option>
                                                <option value="375">بيلاروسيا</option>
                                                <option value="32">بلجيكا</option>
                                                <option value="501">بليز</option>
                                                <option value="229">بنين</option>
                                                <option value="1441">برمودا</option>
                                                <option value="975">بوتان</option>
                                                <option value="591">بوليفيا</option>
                                                <option value="387">البوسنة والهرسك</option>
                                                <option value="267">بوتسوانا</option>
                                                <option value="55">البرازيل</option>
                                                <option value="246">إقليم المحيط الهندي البريطاني</option>
                                                <option value="673">بروناي</option>
                                                <option value="359">بلغاريا</option>
                                                <option value="226">بوركينا فاسو</option>
                                                <option value="257">بوروندي</option>
                                                <option value="855">كمبوديا</option>
                                                <option value="237">الكاميرون</option>
                                                <option value="1">كندا</option>
                                                <option value="238">الرأس الأخضر</option>
                                                <option value="1345">جزر كايمان</option>
                                                <option value="236">جمهورية أفريقيا الوسطى</option>
                                                <option value="235">تشاد</option>
                                                <option value="56">تشيلي</option>
                                                <option value="86">الصين</option>
                                                <option value="61">جزيرة عيد الميلاد</option>
                                                <option value="672">جزر كوكس</option>
                                                <option value="57">كولومبيا</option>
                                                <option value="269">جزر القمر</option>
                                                <option value="242">جمهورية الكونغو</option>
                                                <option value="243">جمهورية الكونغو الديمقراطية</option>
                                                <option value="682">جزر كوك</option>
                                                <option value="506">كوستاريكا</option>
                                                <option value="225">ساحل العاج</option>
                                                <option value="385">كرواتيا</option>
                                                <option value="53">كوبا</option>
                                                <option value="599">كوراساو</option>
                                                <option value="357">قبرص</option>
                                                <option value="420">جمهورية التشيك</option>
                                                <option value="45">الدنمارك</option>
                                                <option value="253">جيبوتي</option>
                                                <option value="1767">دومينيكا</option>
                                                <option value="1849">جمهورية الدومينيكان</option>
                                                <option value="593">الإكوادور</option>
                                                <option value="20">مصر</option>
                                                <option value="503">السلفادور</option>
                                                <option value="240">غينيا الاستوائية</option>
                                                <option value="291">إريتريا</option>
                                                <option value="372">إستونيا</option>
                                                <option value="251">إثيوبيا</option>
                                                <option value="500">جزر فوكلاند</option>
                                                <option value="298">جزر فارو</option>
                                                <option value="679">فيجي</option>
                                                <option value="358">فنلندا</option>
                                                <option value="33">فرنسا</option>
                                                <option value="594">غويانا الفرنسية</option>
                                                <option value="689">بولينزيا الفرنسية</option>
                                                <option value="241">الغابون</option>
                                                <option value="220">غامبيا</option>
                                                <option value="995">جورجيا</option>
                                                <option value="49">ألمانيا</option>
                                                <option value="233">غانا</option>
                                                <option value="350">جبل طارق</option>
                                                <option value="30">اليونان</option>
                                                <option value="299">جرينلاند</option>
                                                <option value="1473">غرينادا</option>
                                                <option value="590">غوادلوب</option>
                                                <option value="1671">غوام</option>
                                                <option value="502">غواتيمالا</option>
                                                <option value="44">غيرنسي</option>
                                                <option value="224">غينيا</option>
                                                <option value="245">غينيا بيساو</option>
                                                <option value="592">غيانا</option>
                                                <option value="509">هايتي</option>
                                                <option value="504">هندوراس</option>
                                                <option value="852">هونغ كونغ</option>
                                                <option value="36">المجر</option>
                                                <option value="354">آيسلندا</option>
                                                <option value="91">الهند</option>
                                                <option value="62">إندونيسيا</option>
                                                <option value="98">إيران</option>
                                                <option value="964">العراق</option>
                                                <option value="353">أيرلندا</option>
                                                <option value="44">جزيرة مان</option>
                                                <option value="972">إسرائيل</option>
                                                <option value="39">إيطاليا</option>
                                                <option value="1876">جامايكا</option>
                                                <option value="81">اليابان</option>
                                                <option value="44">جيرسي</option>
                                                <option value="962">الأردن</option>
                                                <option value="7">كازاخستان</option>
                                                <option value="254">كينيا</option>
                                                <option value="686">كيريباتي</option>
                                                <option value="850">كوريا الشمالية</option>
                                                <option value="82">كوريا الجنوبية</option>
                                                <option value="965">الكويت</option>
                                                <option value="996">قيرغيزستان</option>
                                                <option value="856">لاوس</option>
                                                <option value="371">لاتفيا</option>
                                                <option value="961">لبنان</option>
                                                <option value="266">ليسوتو</option>
                                                <option value="231">ليبيريا</option>
                                                <option value="218">ليبيا</option>
                                                <option value="423">ليختنشتاين</option>
                                                <option value="370">ليتوانيا</option>
                                                <option value="352">لوكسمبورغ</option>
                                                <option value="853">ماكاو</option>
                                                <option value="389">مقدونيا الشمالية</option>
                                                <option value="261">مدغشقر</option>
                                                <option value="265">ملاوي</option>
                                                <option value="60">ماليزيا</option>
                                                <option value="960">جزر المالديف</option>
                                                <option value="223">مالي</option>
                                                <option value="356">مالطا</option>
                                                <option value="596">مارتينيك</option>
                                                <option value="222">موريتانيا</option>
                                                <option value="230">موريشيوس</option>
                                                <option value="262">مايوت</option>
                                                <option value="52">المكسيك</option>
                                                <option value="691">ولايات ميكرونيسيا المتحدة</option>
                                                <option value="373">مولدوفا</option>
                                                <option value="377">موناكو</option>
                                                <option value="976">منغوليا</option>
                                                <option value="382">الجبل الأسود</option>
                                                <option value="1664">مونتسيرات</option>
                                                <option value="212">المغرب</option>
                                                <option value="258">موزمبيق</option>
                                                <option value="95">ميانمار</option>
                                                <option value="264">ناميبيا</option>
                                                <option value="674">ناورو</option>
                                                <option value="977">نيبال</option>
                                                <option value="31">هولندا</option>
                                                <option value="687">كاليدونيا الجديدة</option>
                                                <option value="64">نيوزيلندا</option>
                                                <option value="505">نيكاراغوا</option>
                                                <option value="227">النيجر</option>
                                                <option value="234">نيجيريا</option>
                                                <option value="683">نيوي</option>
                                                <option value="672">جزيرة نورفولك</option>
                                                <option value="1670">جزر ماريانا الشمالية</option>
                                                <option value="47">النرويج</option>
                                                <option value="968">عمان</option>
                                                <option value="92">باكستان</option>
                                                <option value="680">بالاو</option>
                                                <option value="970">فلسطين</option>
                                                <option value="507">بنما</option>
                                                <option value="675">بابوا غينيا الجديدة</option>
                                                <option value="595">باراغواي</option>
                                                <option value="51">بيرو</option>
                                                <option value="63">الفلبين</option>
                                                <option value="872">جزر بيتكيرن</option>
                                                <option value="48">بولندا</option>
                                                <option value="351">البرتغال</option>
                                                <option value="1939">بورتوريكو</option>
                                                <option value="974">قطر</option>
                                                <option value="262">ريونيون</option>
                                                <option value="40">رومانيا</option>
                                                <option value="7">روسيا</option>
                                                <option value="250">رواندا</option>
                                                <option value="590">سانت بارتيليمي</option>
                                                <option value="685">ساموا</option>
                                                <option value="378">سان مارينو</option>
                                                <option value="239">ساو تومي وبرينسيبي</option>
                                                <option value="966">المملكة العربية السعودية</option>
                                                <option value="221">السنغال</option>
                                                <option value="381">صربيا</option>
                                                <option value="248">سيشل</option>
                                                <option value="232">سيراليون</option>
                                                <option value="65">سنغافورة</option>
                                                <option value="421">سلوفاكيا</option>
                                                <option value="386">سلوفينيا</option>
                                                <option value="677">جزر سليمان</option>
                                                <option value="252">الصومال</option>
                                                <option value="27">جنوب أفريقيا</option>
                                                <option value="211">جنوب السودان</option>
                                                <option value="34">إسبانيا</option>
                                                <option value="94">سريلانكا</option>
                                                <option value="290">سانت هيلينا وأسينشين وتريستان دا كونا</option>
                                                <option value="508">سان بيير وميكلون</option>
                                                <option value="249" selected>السودان</option>
                                                <option value="597">سورينام</option>
                                                <option value="268">إسواتيني</option>
                                                <option value="46">السويد</option>
                                                <option value="41">سويسرا</option>
                                                <option value="963">سوريا</option>
                                                <option value="886">تايوان</option>
                                                <option value="992">طاجيكستان</option>
                                                <option value="255">تنزانيا</option>
                                                <option value="66">تايلاند</option>
                                                <option value="228">توغو</option>
                                                <option value="690">توكيلاو</option>
                                                <option value="670">تيمور الشرقية</option>
                                                <option value="676">تونغا</option>
                                                <option value="1868">ترينيداد وتوباغو</option>
                                                <option value="216">تونس</option>
                                                <option value="90">تركيا</option>
                                                <option value="993">تركمانستان</option>
                                                <option value="1649">جزر تركس وكايكوس</option>
                                                <option value="688">توفالو</option>
                                                <option value="256">أوغندا</option>
                                                <option value="380">أوكرانيا</option>
                                                <option value="971">الإمارات العربية المتحدة</option>
                                                <option value="44">المملكة المتحدة</option>
                                                <option value="1">الولايات المتحدة</option>
                                                <option value="598">الأوروغواي</option>
                                                <option value="998">أوزبكستان</option>
                                                <option value="678">فانواتو</option>
                                                <option value="58">فنزويلا</option>
                                                <option value="84">فيتنام</option>
                                                <option value="1284">جزر العذراء البريطانية</option>
                                                <option value="1340">جزر العذراء الأمريكية</option>
                                                <option value="681">واليس وفوتونا</option>
                                                <option value="967">اليمن</option>
                                                <option value="260">زامبيا</option>
                                                <option value="263">زيمبابوي</option>
                                            </select>
                                        </div>
                                        <input id="phone" type="text"
                                               class="form-control @error('phone') is-invalid @enderror"
                                               placeholder="912345678"
                                               name="phone"
                                               required autocomplete="off"
                                               style="border-radius: 0 3px 3px 0!important; height: 100%;"
                                               value="{{ old('phone') }}">
                                    </div>
                                </div>
                                @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group row mb-4 col-12 col-lg-6   px-0 pt-2 ">
                                <div class="col-md-12 px-2 pt-4" style="position: relative;">
                                    <label for="password"
                                           class="col-form-label text-md-right mb-1 font-small px-2 py-1 d-inline"
                                           style="background:#f4f4f4;position: absolute;top: 17px;right: 20px;border-radius: 3px!important">كلمة
                                        المرور</label>
                                    <input id="password" type="password"
                                           class="form-control mt-2 d-inline-block @error('password') is-invalid @enderror"
                                           name="password" value="" required="" autocomplete="off" autofocus=""
                                           style=";height: 42px;border-color: #eaedf1;border-radius: 3px!important"
                                           minlength="6" aria-invalid="true">
                                </div>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                @enderror
                            </div>
                            <div class="form-group row mb-4 col-12 col-lg-6   px-0 pt-2 ">
                                <div class="col-md-12 px-2 pt-4" style="position: relative;">
                                    <label for="password_confirmation"
                                           class="col-form-label text-md-right mb-1 font-small px-2 py-1 d-inline"
                                           style="background:#f4f4f4;position: absolute;top: 17px;right: 20px;border-radius: 3px!important">تأكيد
                                        كلمة المرور</label>
                                    <input id="password_confirmation" type="password"
                                           class="form-control mt-2 d-inline-block @error('password_confirmation') is-invalid @enderror"
                                           name="password_confirmation" value="" required="" autocomplete="off"
                                           autofocus=""
                                           style=";height: 42px;border-color: #eaedf1;border-radius: 3px!important"
                                           minlength="6" aria-invalid="true">
                                </div>
                                @error('password_confirmation')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                @enderror
                            </div>
                            <div class="col-12 p-0 row d-flex align-items-center justify-content-start">
                                <div class="col-12  p-2 ">
                                    <div class="form-group row mb-0 ">
                                        <div class="col-12 p-0 d-flex ">
                                            <button type="submit" class="btn btn-success font-1">
                                                تسجيل الآن
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 px-4 py-2">
                                <div class="col-12 px-0 mb-2">
                                    مساعدة
                                </div>
                                <ul style="list-style:none;" class="p-0 m-0">
                                    @if (Route::has('login'))
                                        <li class=" d-block"><a href="{{route('login')}}" class="naskh py-2 d-block"
                                                                style="text-decoration: none!important;"><span
                                                    class="fas fa-circle font-small"></span> لديك حساب بالفعل</a></li>
                                    @endif
                                    @if (Route::has('password.request'))
                                        <li class="d-block"><a href="{{ route('password.request') }}"
                                                               class="naskh py-2 d-block"
                                                               style="text-decoration: none!important;"><span
                                                    class="fas fa-circle font-small"></span> نسيت كلمة المرور</a></li>
                                    @endif
                                </ul>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div
                class="col-12 col-lg-6 d-none d-lg-flex text-center p-0 d-flex align-items-center justify-content-center row position-relative"
                style="">
                <div class="overlap-grid overlap-grid-2">
                    <div class="item mx-auto">
                        <div class="shape bg-dot primary rellax w-16 h-20" data-rellax-speed="1"
                             style="top: 3rem; left: 5.5rem"></div>
                        <div class="col-12 p-0 align-items-center py-5 justify-content-center d-flex svg-animation"
                             style="background-image: url('{{$settings['get_website_logo']}}');background-size: cover;padding-top: 57%;background-position: center;height: 400px;z-index: 1;position: relative;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <style type="text/css">
    #navbar {
        display: none;
    }

    body {
        background: #fff;
    }

    </style>
    <div class="col-12 p-0 row">
        <div class="col-12 col-md-6 text-center p-0" style="">
            <div class="col-12 p-4 align-items-center justify-content-center d-flex row" style="height:100vh">
                <div class="col-12 p-0">
                    <form method="POST" action="{{ route('register') }}" id="register-form">
                        @csrf
                        <input type="hidden" name="recaptcha" id="recaptcha">
                        <div class="col-12 p-0 mb-5" style="width: 550px;max-width: 100%;margin: 0px auto;">
                            <h3 class="mb-4">{{ __('lang.register') }}</h3>
                        </div>
                        <div class="form-group row mb-4">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('lang.name') }}</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('lang.email') }}</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('lang.password') }}</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('lang.confirm_password') }}</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>
                        <div class="form-group row mb-4 mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('lang.register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 p-0 d-none d-md-block">
            <div style="height: 100vh;background-image: url('{{asset('/images/auth-backgroud.jpg')}}');object-fit: cover;    vertical-align: middle;background-size: cover;background-repeat: no-repeat;"></div>
        </div>
    </div> --}}
@endsection
@section('scripts')
    <script src="https://www.google.com/recaptcha/api.js?render={{ env("RECAPTCHA_SITE_KEY") }}"></script>
    <script>
        grecaptcha.ready(function () {
            document.getElementById('register-form').addEventListener("submit", function (event) {
                event.preventDefault();
                grecaptcha.execute('{{ env("RECAPTCHA_SITE_KEY") }}', {action: 'register'}).then(function (token) {
                    document.getElementById("recaptcha").value = token;
                    document.getElementById('register-form').submit();
                });
            }, false);
        });

    </script>
@endsection
