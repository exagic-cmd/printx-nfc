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
            background-color: #ffffff;
            color: #333;
            line-height: 1.6;
        }
        
        .vcard-container {
            max-width: 450px;
            margin: 20px auto;
            background: {{ $receipt->organization->background_color ?? '#ffffff' }};
            text-align: center;
            overflow: hidden;
        }
        
        .top-logo-section {
            padding: 20px 10px;
        }
        
        .top-org-logo {
            max-width: 150px;
            max-height: 60px;
            object-fit: contain;
        }
        
        .header-block-container {
            position: relative;
            padding-top: 60px; /* Space for image overlap */
            margin-bottom: 20px;
        }

        .blue-header-block {
            background: {{ $receipt->organization->color_scheme ?? '#003399' }};
            border-radius: 40px;
            padding: 65px 20px 20px;
            margin: 0 15px;
            color: white;
            position: relative;
        }
        
        .profile-image-container {
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            z-index: 2;
        }
        
        .profile-image {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 4px solid white;
            object-fit: cover;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .profile-initials {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 4px solid white;
            background: {{ $receipt->organization->color_scheme ?? '#003399' }};
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            font-weight: bold;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }
        
        h1 {
            font-size: 24px;
            margin-bottom: 0px;
            font-weight: bold;
            line-height: 1.2;
        }
        
        .designation {
            font-size: 16px;
            opacity: 0.9;
            margin-bottom: 0px;
            line-height: 1;
        }

        .organization-name {
            font-size: 14px;
            opacity: 0.8;
            margin-top: 2px;
            line-height: 1.2;
        }
        
        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 30px;
            padding: 0 15px;
        }
        
        .btn-action {
            flex: 1;
            background: {{ $receipt->organization->color_scheme ?? '#003399' }};
            color: white;
            padding: 10px;
            border-radius: 50px;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .btn-action i {
            margin-right: 8px;
            color: white; /* Ensure icons inside buttons are white */
        }
        
        .vcard-body {
            padding: 0 20px;
            text-align: left;
        }
        
        .contact-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 12px;
        }
        
        .contact-item .icon-box {
            width: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            padding-top: 8px; /* Align with first line of text box */
        }
        
        .contact-item i {
            font-size: 18px;
            color: {{ $receipt->organization->color_scheme ?? '#003399' }};
        }
        
        .contact-item .text-box {
            flex: 1;
            background: #f1f1f1;
            padding: 8px 15px;
            border-radius: 10px;
            font-size: 14px;
            color: #444;
            margin-left: 10px;
            word-break: break-word;
        }
        
        .contact-item a {
            text-decoration: none;
            color: inherit;
        }
        
        .download-section {
            padding: 30px 20px;
            text-align: center;
        }
        
        .btn-download {
            display: inline-block;
            background: {{ $receipt->organization->color_scheme ?? '#003399' }};
            color: white;
            padding: 12px 30px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: bold;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .vcard-footer {
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #666;
            letter-spacing: 1px;
        }
        
        .vcard-footer img {
            vertical-align: middle;
            margin-left: 5px;
        }

        @media (max-width: 480px) {
            .vcard-container {
                margin: 0;
                max-width: 100%;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <div class="vcard-container">
        <!-- Top Logo Section -->
        @if($receipt->organization->logo)
        <div class="top-logo-section">
            <img src="{{ asset('uploads/organizations/' . $receipt->organization->logo) }}" alt="Company Logo" class="top-org-logo">
        </div>
        @endif

        <!-- Header Block with Overlapping Profile Image -->
        <div class="header-block-container">
            <div class="profile-image-container">
                @if($receipt->profile_picture)
                    <img src="{{ asset('uploads/receipts/' . $receipt->profile_picture) }}" alt="Profile Photo" class="profile-image">
                @else
                    <div class="profile-initials">
                        {{ $receipt->initials }}
                    </div>
                @endif
            </div>
            <div class="blue-header-block">
                <h1>{{ $receipt->name }}</h1>
                @if($receipt->designation)
                    <div class="designation">{{ $receipt->designation }}</div>
                @endif
                @if($receipt->organization->name)
                    <h4 style="font-size:16px;opacity: 0.9;">{{ $receipt->organization->name }}</h4>
                @endif
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            @if($receipt->phone)
            <a href="tel:{{ $receipt->phone }}" class="btn-action">
                <i class="fas fa-phone-alt"></i> Call
            </a>
            @endif
            @if($receipt->phone2)
            <a href="tel:{{ $receipt->phone2 }}" class="btn-action">
                <i class="fas fa-mobile-alt"></i> Call 2
            </a>
            @endif
            @if($receipt->email)
            <a href="mailto:{{ $receipt->email }}" class="btn-action">
                <i class="fas fa-envelope"></i> Email
            </a>
            @endif
        </div>

        <!-- Contact Info Listing -->
        <div class="vcard-body">
            @if($receipt->phone)
            <div class="contact-item">
                <div class="icon-box"><i class="fas fa-phone-alt"></i></div>
                <div class="text-box"><a href="tel:{{ $receipt->phone }}">{{ $receipt->phone }}</a></div>
            </div>
            @endif
            
            @if($receipt->phone2)
            <div class="contact-item">
                <div class="icon-box"><i class="fas fa-mobile-alt"></i></div>
                <div class="text-box"><a href="tel:{{ $receipt->phone2 }}">{{ $receipt->phone2 }}</a></div>
            </div>
            @endif

            @if($receipt->organizationAddress)
                @if($receipt->organizationAddress->office_number)
                <div class="contact-item">
                    <div class="icon-box"><i class="fas fa-phone-alt"></i></div>
                    <div class="text-box"><a href="tel:{{ $receipt->organizationAddress->office_number }}">{{ $receipt->organizationAddress->office_number }}</a></div>
                </div>
                @endif
                
                @if($receipt->organizationAddress->fax_number)
                <div class="contact-item">
                    <div class="icon-box"><i class="fas fa-fax"></i></div>
                    <div class="text-box">{{ $receipt->organizationAddress->fax_number }}</div>
                </div>
                @endif
            @elseif($receipt->organization->office_number)
            <div class="contact-item">
                <div class="icon-box"><i class="fas fa-phone-alt"></i></div>
                <div class="text-box"><a href="tel:{{ $receipt->organization->office_number }}">{{ $receipt->organization->office_number }}</a></div>
            </div>
            @endif

            @if($receipt->email)
            <div class="contact-item">
                <div class="icon-box"><i class="fas fa-envelope"></i></div>
                <div class="text-box"><a href="mailto:{{ $receipt->email }}">{{ $receipt->email }}</a></div>
            </div>
            @endif

            @if($receipt->organization->website)
                @php
                    $website = $receipt->organization->website;
                    if ($website && !preg_match('/^https?:\/\//', $website)) {
                        $website = 'http://' . $website;
                    }
                @endphp
                <div class="contact-item">
                    <div class="icon-box"><i class="fas fa-globe"></i></div>
                    <div class="text-box"><a href="{{$website}}" target="_blank">{{ $receipt->organization->website }}</a></div>
                </div>
            @endif

            @if($receipt->organization->facebook)
            <div class="contact-item">
                <div class="icon-box"><i class="fab fa-facebook-f"></i></div>
                <div class="text-box"><a href="{{ $receipt->organization->facebook }}" target="_blank">{{ $receipt->organization->facebook }}</a></div>
            </div>
            @endif

            @if($receipt->organization->instagram)
            <div class="contact-item">
                <div class="icon-box"><i class="fab fa-instagram"></i></div>
                <div class="text-box"><a href="{{ $receipt->organization->instagram }}" target="_blank">{{ $receipt->organization->instagram }}</a></div>
            </div>
            @endif

            @if($receipt->organizationAddress && $receipt->organizationAddress->office_address)
            <div class="contact-item">
                <div class="icon-box"><i class="fas fa-map-marker-alt"></i></div>
                <div class="text-box">{{$receipt->organizationAddress->office_address}}</div>
            </div>
            @elseif($receipt->organization->office_address)
            <div class="contact-item">
                <div class="icon-box"><i class="fas fa-map-marker-alt"></i></div>
                <div class="text-box">{{$receipt->organization->office_address}}</div>
            </div>
            @endif
        </div>

        <!-- Download Section -->
        <div class="download-section">
            <a href="{{ route('vcard.download', $receipt->id) }}" class="btn-download">
                Download VCARD
            </a>
        </div>

        <!-- Footer -->
        <div class="vcard-footer">
            POWERED BY <a href="https://printx.ae/"><img src="{{asset('logo-web.png')}}" style="width:55px" alt="PrintX Logo"/></a>
        </div>
    </div>
</body>
</html>