<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>TIN Certificate - {{ $request->tin_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .certificate {
            max-width: 800px;
            margin: 0 auto;
            padding: 30px;
            border: 15px solid #1a5a96;
            position: relative;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #1a5a96;
            padding-bottom: 10px;
        }
        .logo {
            max-width: 100px;
            margin-bottom: 10px;
        }
        h1 {
            color: #1a5a96;
            margin: 0;
            font-size: 24px;
        }
        .subtitle {
            font-size: 18px;
            color: #555;
            margin: 5px 0 0;
        }
        .content {
            margin: 30px 0;
        }
        .section {
            margin-bottom: 20px;
        }
        .section-title {
            font-weight: bold;
            font-size: 18px;
            color: #1a5a96;
            margin-bottom: 10px;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 150px 1fr;
            gap: 10px;
            margin-bottom: 10px;
        }
        .label {
            font-weight: bold;
            color: #555;
        }
        .value {
            color: #333;
        }
        .signature {
            margin-top: 50px;
            text-align: right;
        }
        .signature-line {
            border-top: 1px solid #333;
            display: inline-block;
            width: 200px;
            margin-top: 50px;
        }
        .signature-text {
            margin-top: 5px;
            font-style: italic;
        }
        .stamp {
            position: absolute;
            right: 50px;
            bottom: 50px;
            text-align: center;
        }
        .stamp-image {
            max-width: 150px;
            opacity: 0.7;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #777;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 80px;
            font-weight: bold;
            color: rgba(0, 0, 0, 0.1);
            pointer-events: none;
            white-space: nowrap;
            z-index: -1;
        }
    </style>
</head>
<body>
    <div class="watermark">TIN CERTIFICATE</div>
    
    <div class="certificate">
        <div class="header">
            <h1>TAX IDENTIFICATION NUMBER CERTIFICATE</h1>
            <p class="subtitle">National Board of Revenue, Government of the People's Republic of Bangladesh</p>
        </div>
        
        <div class="content">
            <p>This is to certify that the following individual/entity has been registered with the National Board of Revenue and has been assigned the Tax Identification Number (TIN) as mentioned below:</p>
            
            <div class="section">
                <div class="section-title">Taxpayer Information</div>
                <div class="info-grid">
                    <div class="label">TIN Number:</div>
                    <div class="value"><strong>{{ $request->tin_number }}</strong></div>
                    
                    <div class="label">Name:</div>
                    <div class="value">{{ $request->full_name }}</div>
                    
                    <div class="label">Father's Name:</div>
                    <div class="value">{{ $request->father_name }}</div>
                    
                    <div class="label">Mother's Name:</div>
                    <div class="value">{{ $request->mother_name }}</div>
                    
                    @if($request->spouse_name)
                        <div class="label">Spouse's Name:</div>
                        <div class="value">{{ $request->spouse_name }}</div>
                    @endif
                    
                    <div class="label">Date of Birth:</div>
                    <div class="value">{{ $request->date_of_birth->format('F j, Y') }}</div>
                    
                    <div class="label">NID Number:</div>
                    <div class="value">{{ $request->nid_number }}</div>
                    
                    <div class="label">Address:</div>
                    <div class="value">
                        {{ $request->present_address }}<br>
                        <small>(Present Address)</small>
                        
                        @if($request->present_address !== $request->permanent_address)
                            <br><br>
                            {{ $request->permanent_address }}
                            <small>(Permanent Address)</small>
                        @endif
                    </div>
                    
                    <div class="label">Occupation:</div>
                    <div class="value">{{ $request->occupation }}</div>
                    
                    @if($request->company_name)
                        <div class="label">Company/Business:</div>
                        <div class="value">
                            {{ $request->company_name }}
                            @if($request->company_address)
                                <br><small>{{ $request->company_address }}</small>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="section">
                <div class="section-title">Registration Details</div>
                <div class="info-grid">
                    <div class="label">Date of Issue:</div>
                    <div class="value">{{ now()->format('F j, Y') }}</div>
                    
                    <div class="label">Tax Circle:</div>
                    <div class="value">Dhaka North</div>
                    
                    <div class="label">Tax Zone:</div>
                    <div class="value">Zone-10, Dhaka</div>
                </div>
            </div>
            
            <div class="signature">
                <div class="signature-line"></div>
                <div class="signature-text">
                    Authorized Signature<br>
                    National Board of Revenue<br>
                    Government of the People's Republic of Bangladesh
                </div>
            </div>
            
            <div class="stamp">
                <div>OFFICIAL SEAL</div>
                <div style="border: 1px solid #000; width: 150px; height: 80px; margin: 5px auto; display: flex; align-items: center; justify-content: center;">
                    NBR
                </div>
                <div>Date: {{ now()->format('d/m/Y') }}</div>
            </div>
        </div>
        
        <div class="footer">
            <p>This is a computer-generated document. No signature is required.</p>
            <p>For verification, please visit: https://nbr.gov.bd/tin-verification</p>
            <p>© {{ date('Y') }} National Board of Revenue. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
