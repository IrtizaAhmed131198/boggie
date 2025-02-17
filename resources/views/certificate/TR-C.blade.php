<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Certificate</title>
</head>

<body>

    <style>
        /* Set exact dimensions for the PDF */
        .main-certificate {
            background-image: url("{{ asset('images/trc.png') }}");
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            height: 490px;
            width: 100%;
            margin: auto;
            /* border: 5px solid #333; */
            /* padding: 30px; */
            box-sizing: border-box;
            position: relative;
            text-align: center;
            /* display: flex; */
            /* align-items: center; */
            /* padding-top: 148px; */
        }
        .certificate-holder {
        text-align: center;
        padding-top: 150px;
        }

        .certificate-holder {
            text-align: center;
            /* padding-top: 150px; */
        }

        .certificate-holder h1 {
            font-size: 27px;
            color: #333;
            font-weight: 600;
            margin-bottom: 10px;
            margin-top: 0;
        }

        .certificate-holder p {
            color: #333;
            font-size: 15px;
            font-weight: 500;
            width: 80%;
            margin: auto;
            font-weight: 600;
            color: black;
        }

        .para-bottom {
            margin: auto;
            margin-top: 10px;
            /* width: 80%; */
        }

        /* Remove media print styles as they may not be needed in the PDF */
    </style>


    <section class="get-certificate" style="width: 650px; height: 900px; margin: auto; padding: 50px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 p-0">
                    <div class="main-certificate">
                        <div class="certificate-holder">
                            <h1>{{ $name }}</h1>
                            <p>has completed <span class="d-block">{{ $course }}</span>On this day <span class="d-block">{{ $date }}</span></p>
                            <div class="para-bottom">
                                <p>This continuing education course is approved by the International Board of Specialty
                                    Certification (IBSC) and certified by Goat-Trail Austere Medical Solutions (GAMS)
                                    through the Tactical Austere Medical Practitioner (TAMP) Course. </p>
                                <p>It provides 16 hours of continuing education toward the Tactical Responder
                                    Certification.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</body>



</html>
