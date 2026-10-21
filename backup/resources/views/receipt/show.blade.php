<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PrintX | Information</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }
        
        body {
            background-color: #f5f5f5;
            color: #333;
            line-height: 1.6;
        }
        
        .vcard-container {
            max-width: 500px;
            margin: 50px auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .vcard-header {
            background: #2c3e50;
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .profile-image {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 4px solid white;
            object-fit: cover;
            margin-bottom: 15px;
        }
        
        h1 {
            font-size: 28px;
            margin-bottom: 5px;
        }
        
        .title {
            font-size: 16px;
            opacity: 0.9;
            margin-bottom: 15px;
        }
        
        .vcard-body {
            padding: 20px;
        }
        
        .contact-info {
            margin-bottom: 25px;
        }
        
        .contact-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .contact-item i {
            width: 30px;
            font-size: 18px;
            color: #2c3e50;
            margin-right: 10px;
            text-align: center;
        }
        
        .social-links {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
        
        .social-links a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: #2c3e50;
            color: white;
            border-radius: 50%;
            margin: 0 5px;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .social-links a:hover {
            background: #3498db;
            transform: translateY(-3px);
        }
        
        .vcard-footer {
            background: #f9f9f9;
            padding: 15px;
            text-align: center;
            font-size: 16px;
            color: #000000;
        }
        .btn-info{
            background: #2c3e50;
            padding: 10px 25px 10px 25px;
            color: white;
            text-decoration-line: none;
            border-radius: 5px;
        }
        .btn-info-head{
            background: #5a8bb1;
            padding: 10px 25px 10px 25px;
            color: white;
            text-decoration-line: none;
            border-radius: 5px;
        }
        a{
            color: #383636;
    text-decoration-line: none;
        }
        @media (max-width: 600px) {
            .vcard-container {
                margin: 20px;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
          <div class="vcard-container">
        <div class="vcard-header">
            <!--<img src="{{asset('assets/img/user2-160x160.jpg')}}" alt="Profile Photo" class="profile-image">-->
            <h1 style="line-height:32px"> {{ $receipt->name }}</h1>
            <div class="title"> {{ $receipt->designation }} <h4>{{$receipt->company}}</h4></div>
            
            <div>
                <a href="tel:{{ $receipt->phone }}" class="btn btn-block btn-info-head"><i class="fas fa-phone-alt"></i></i>&nbsp;&nbsp;Call</a>
                <a href="mailto:{{ $receipt->email }}" class="btn btn-block btn-info-head"><i class="fas fa-envelope"></i>&nbsp;&nbsp;Email</a>
            </div>
        </div>
        
        <div class="vcard-body">
            <div class="contact-info">
                <!--@if($receipt->name)-->
                <!--<div class="contact-item">-->
                <!--    <i class="fas fa-user"></i>-->
                <!--    <span> {{ $receipt->name }}</span>-->
                <!--</div>-->
                <!--@endif-->
                @if($receipt->phone)
                <div class="contact-item">
                    <i class="fas fa-phone-alt"></i>
                    <span> <a href="tel:{{ $receipt->phone }}">{{ $receipt->phone }}</a></span>
                </div>
                @endif
                @if($receipt->office_phone)
                <div class="contact-item">
                    <i class="fas fa-phone-alt"></i>
                     <span> <a href="tel:{{ $receipt->office_phone }}">{{ $receipt->office_phone }}</a></span>
                </div>
                @endif
                @if($receipt->email)
                <div class="contact-item">
                    <i class="fas fa-envelope"></i>
                     <span> <a href="mailto:{{ $receipt->email }}">{{ $receipt->email }}</a></span>
                </div>
                @endif
                @if($receipt->website)
                
                @php
                    $website = $receipt->website;
                    if ($website && !preg_match('/^https?:\/\//', $website)) {
                        $website = 'http://' . $website;
                    }
                @endphp
                <div class="contact-item">
                    <i class="fas fa-globe"></i>
                     <span> <a href="{{$website}}" target="_blank">{{ $receipt->website }}</a></span>
                </div>
                @endif
                @if($receipt->facebook)
                <div class="contact-item">
                <i class="fab fa-facebook-f"></i>
                    <span> <a href="{{ $receipt->facebook }}" target="_blank">{{ $receipt->facebook }}</a></span>
                </div>
                @endif
                @if($receipt->instagram)
                <div class="contact-item">
                <i class="fab fa-instagram"></i>
                    <span> <a href="{{ $receipt->instagram }}" target="_blank">{{ $receipt->instagram }}</a></span>
                </div>
                @endif
                @if($receipt->address)
                <div class="contact-item">
                    <i class="fas fa-map-marker-alt" style="font-size:24px"></i>
                    <span style="width: fit-content;"> {{$receipt->address}}</span>
                </div>
                @endif
            </div>
            
    <a href="{{ route('vcard.download', $receipt->id) }}" class="btn btn-block btn-info">
    Download VCARD
</a>
    </div>
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content-->
        <div class="vcard-footer">
           POWERED BY <a href="https://printx.ae/"><img src="{{asset('logo-web.png')}}" style="width:55px"/></a>
        </div>
  </div>
</body>
</html>