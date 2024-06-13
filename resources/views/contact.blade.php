<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <style>
        /* Base styles */
        * {
            padding: 0;
            box-sizing: border-box;
            margin: 0;
        }

        body {
            background: #ffffff;
        }

        body,
        input,
        textarea,
        a {
            font-family: 'Lato', sans-serif;
        }

        #section-wrapper {
            width: 100%;
            padding: 10px;
        }

        .box-wrapper {
            position: relative;
            display: flex;
            width: 1100px;
            margin: auto;
            margin-top: 35px;
            border-radius: 30px;
            flex-wrap: wrap;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-wrap {
            width: 65%;
            padding: 40px 25px 35px 25px;
            border-radius: 30px 0 0 30px;
            background: #ecf0f3;
        }

        .form-title {
            text-align: left;
            margin-left: 23px;
            font-size: 28px;
            letter-spacing: 0.5px;
        }

        .form-fields {
            width: 100%;
            padding: 15px 5px 5px 5px;
        }

        .form-group {
            width: 46%;
            float: left;
            padding: 0px 30px;
            margin: 14px 12px;
            border-radius: 25px;
            box-shadow: inset 8px 8px 8px #8e9ba5, inset -8px -8px 8px #ffffff;
        }

        .form-group.full-width {
            width: 96%;
        }

        .form-fields input,
        .form-fields textarea {
            border: none;
            outline: none;
            background: none;
            font-size: 18px;
            color: #333;
            padding: 20px 10px 20px 5px;
            width: 100%;
        }

        .form-fields textarea {
            height: 150px;
            resize: none;
        }

        .submit-button {
            width: 96%;
            height: 60px;
            margin: 0px 12px;
            border-radius: 30px;
            font-size: 20px;
            font-weight: 700;
            outline: none;
            cursor: pointer;
            color: #fff;
            text-align: center;
            background: #0661ff;
            box-shadow: 3px 3px 8px #b1b1bb, -3px -3px 8px #ffffff;
            transition: .5s;
        }

        .submit-button:hover {
            background: #fafafa;
            color: #000000;
        }

        .info-wrap {
            width: 35%;
            padding: 40px;
            border-radius: 0 30px 30px 0;
            background: linear-gradient(144deg, #005eff 0%, #ffffff 100%);
            color: #fff;
        }

        .info-title {
            text-align: left;
            font-size: 28px;
            letter-spacing: 0.5px;
        }

        .sub-title {
            font-size: 18px;
            font-weight: 300;
            margin-top: 17px;
            letter-spacing: 0.5px;
            line-height: 26px;
        }

        .info-details {
            list-style: none;
            margin: 60px 0px;
        }

        .info-details li {
            display: flex;
            align-items: center;
            margin-top: 25px;
            font-size: 18px;
            color: #ffffff;
        }

        .info-details li i {
            margin-right: 15px;
        }

        .info-details li svg {
            width: 24px;
            height: 24px;
            fill: #ffffff;
        }

        .info-details li a {
            color: #fff;
            text-decoration: none;
            margin-left: 5px;
        }

        .info-details li a:hover {
            color: aqua;
        }

        .social-icons {
            list-style: none;
            text-align: center;
            margin: 20px 0px;
        }

        .social-icons li {
            display: inline-block;
            margin: 0 10px;
        }

        .social-icons li svg {
            width: 24px;
            height: 24px;
            fill: #ffffff;
            transition: all 0.5s;
        }

        .social-icons li svg:hover {
            fill: #000000;
        }

        /* Responsive css */
        @media only screen and (max-width: 767px) {
            .box-wrapper {
                width: 100%;
                flex-direction: column;
            }

            .info-wrap,
            .form-wrap {
                width: 100%;
                height: inherit;
            }

            .info-wrap {
                border-radius: 0 0 30px 30px;
            }

            .form-wrap {
                border-radius: 30px 30px 0 0;
            }

            .form-group {
                width: 100%;
                margin: 25px 0px;
            }

            .form-group.full-width {
                width: 100%;
            }

            .submit-button {
                width: 100%;
                margin: 10px 0px;
            }
        }
    </style>
</head>

<body>
    <section id="section-wrapper">
        <div class="box-wrapper">
            <div class="form-wrap">
                <form action="#" method="post">
                    <h2 class="form-title">Kirim Pertanyaan</h2>
                    <div class="form-fields">
                        <div class="form-group">
                            <input type="text" class="name" placeholder="Masukkan nama kamu">
                        </div>
                        <div class="form-group">
                            <input type="text" class="username" placeholder="Isi nama panggilan kamu">
                        </div>
                        <div class="form-group">
                            <input type="email" class="email" placeholder="Masukkan email kamu">
                        </div>
                        <div class="form-group">
                            <input type="number" class="nomor" placeholder="Masukkan nomor kamu">
                        </div>
                        <div class="form-group full-width">
                            <textarea name="komentar" placeholder="Apa yang ingin ditanyakan?"></textarea>
                        </div>
                    </div>
                    <input type="reset" value="Kirim" class="submit-button">
                </form>
            </div>
            <div class="info-wrap">
                <h2 class="info-title">Kontak Informasi</h2>
                <h3 class="sub-title">Isi formulir dan tim kami akan menghubungi Anda dalam 24 jam</h3>
                <ul class="info-details">
                    <li>
                        <i class="fas fa-phone-alt"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" />
                            </svg></i>
                        <span>Whatsapp:</span> <a href="tel:08888">08888</a>
                    </li>
                    <li>
                        <i class="fas fa-envelope"><svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd">
                                <path d="M22.288 21h-20.576c-.945 0-1.712-.767-1.712-1.712v-13.576c0-.945.767-1.712 1.712-1.712h20.576c.945 0 1.712.767 1.712 1.712v13.576c0 .945-.767 1.712-1.712 1.712zm-10.288-6.086l-9.342-6.483-.02 11.569h18.684v-11.569l-9.322 6.483zm8.869-9.914h-17.789l8.92 6.229s6.252-4.406 8.869-6.229z" />
                            </svg></i>
                        <span>Email:</span> <a href="mailto:techtutor@gmail.com">techtutor@gmail.com</a>
                    </li>
                    <li>
                        <i class="fas fa-globe"><svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd">
                                <path d="M12.02 0c6.614.011 11.98 5.383 11.98 12 0 6.623-5.376 12-12 12-6.623 0-12-5.377-12-12 0-6.617 5.367-11.989 11.981-12h.039zm3.694 16h-7.427c.639 4.266 2.242 7 3.713 7 1.472 0 3.075-2.734 3.714-7m6.535 0h-5.523c-.426 2.985-1.321 5.402-2.485 6.771 3.669-.76 6.671-3.35 8.008-6.771m-14.974 0h-5.524c1.338 3.421 4.34 6.011 8.009 6.771-1.164-1.369-2.059-3.786-2.485-6.771m-.123-7h-5.736c-.331 1.166-.741 3.389 0 6h5.736c-.188-1.814-.215-3.925 0-6m8.691 0h-7.685c-.195 1.8-.225 3.927 0 6h7.685c.196-1.811.224-3.93 0-6m6.742 0h-5.736c.062.592.308 3.019 0 6h5.736c.741-2.612.331-4.835 0-6m-12.825-7.771c-3.669.76-6.671 3.35-8.009 6.771h5.524c.426-2.985 1.321-5.403 2.485-6.771m5.954 6.771c-.639-4.266-2.242-7-3.714-7-1.471 0-3.074 2.734-3.713 7h7.427zm-1.473-6.771c1.164 1.368 2.059 3.786 2.485 6.771h5.523c-1.337-3.421-4.339-6.011-8.008-6.771" />
                            </svg></i>
                        <span>Website:</span> <a href="http://techtutor.web.id">techtutor.web.id</a>
                    </li>
                </ul>
                <ul class="social-icons">
                    <li>
                        <a href="#">
                            <i class="fab fa-facebook-f"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                    <path d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12v9.293h6.116c.73 0 1.323-.593 1.323-1.325v-21.35c0-.732-.593-1.325-1.325-1.325z" />
                                </svg></i>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fab fa-instagram"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                                </svg></i>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fab fa-twitter"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 512 512">
                                    <path d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z" />
                                </svg></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </section>
</body>

</html>
