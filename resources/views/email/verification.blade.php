<div style="font-family: Avenir, Helvetica, sans-serif, serif, EmojiFont; background-color: rgb(245, 248, 250); color: rgb(116, 120, 126); height: 100%; line-height: 1.4; margin: 0px; word-break: break-word; width: 100% !important;">
    <style type="text/css"><!--  --></style>
    <table class="x_wrapper" width="100%" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif; background-color:#f5f8fa; margin:0; padding:0; width:100%">
        <tbody>
        <tr>
            <td align="center" style="font-family:Avenir,Helvetica,sans-serif">
                <table class="x_content" width="100%" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif; margin:0; padding:0; width:100%">
                    <tbody>
                    <tr>
                        <td class="x_header" style="font-family:Avenir,Helvetica,sans-serif; padding:25px 0; text-align:center">
                            <a href="http://localhost:8080/agraria-v2/" target="_blank" rel="noopener noreferrer" style="font-family:Avenir,Helvetica,sans-serif; color:#bbbfc3; font-size:19px; font-weight:bold; text-decoration:none">{{ env("APP_NAME") }} </a></td>
                    </tr>
                    <tr>
                        <td class="x_body" width="100%" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif; background-color:#FFFFFF; border-bottom:1px solid #EDEFF2; border-top:1px solid #EDEFF2; margin:0; padding:0; width:100%">
                            <table class="x_inner-body" align="center" width="80%" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif; background-color:#FFFFFF; margin:0 auto; padding:0; width:570px">
                                <tbody>
                                <tr>
                                    <td class="x_content-cell" style="font-family:Avenir,Helvetica,sans-serif; padding:35px">
                                        <h1 style="font-family:Avenir,Helvetica,sans-serif; color:#2F3133; font-size:19px; font-weight:bold; margin-top:0; text-align:left">
                                            Hello {{$username}} !</h1>
                                        @if(!empty($password))
                                        <table>
                                            <th><th colspan="3">Login Account:</th></th>
                                            <tr><td>Email</td><td>:</td><td>{{ $email }}</td></tr>
                                            <tr><td>Password</td><td>:</td><td>{{ $password }} (Please Keep it Secret)</td></tr>
                                        </table>
                                        @endif
                                        <p style="font-family:Avenir,Helvetica,sans-serif; color:#74787E; font-size:16px; line-height:1.5em; margin-top:0; text-align:left">
                                            You are receiving this email because you are registered to our system. Please complete the registration process by click the button below.</p>
                                        <table class="x_action" align="center" width="100%" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif; margin:30px auto; padding:0; text-align:center; width:100%">
                                            <tbody>
                                            <tr>
                                                <td align="center" style="font-family:Avenir,Helvetica,sans-serif">
                                                    <table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif">
                                                        <tbody>
                                                        <tr>
                                                            <td align="center" style="font-family:Avenir,Helvetica,sans-serif">
                                                                <table border="0" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif">
                                                                    <tbody>
                                                                    <tr>
                                                                        <td style="font-family:Avenir,Helvetica,sans-serif"><a href="{{ route('user.verifyemail', $email_token)}}" target="_blank" rel="noopener noreferrer" class="x_button x_button-blue" style="font-family:Avenir,Helvetica,sans-serif; border-radius:3px; color:#FFF; display:inline-block; text-decoration:none; background-color:#3097D1; border-top:10px solid #3097D1; border-right:18px solid #3097D1; border-bottom:10px solid #3097D1; border-left:18px solid #3097D1">Verify Account</a> </td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <p style="font-family:Avenir,Helvetica,sans-serif; color:#74787E; font-size:16px; line-height:1.5em; margin-top:0; text-align:left">
                                            If you did not do the registration please ignore this request and contact us if needed.</p>
                                        <p style="font-family:Avenir,Helvetica,sans-serif; color:#74787E; font-size:16px; line-height:1.5em; margin-top:0; text-align:left">
                                            Regards,<br>
                                            {{env("APP_NAME")}}</p>
                                        <table class="x_subcopy" width="100%" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif; border-top:1px solid #EDEFF2; margin-top:25px; padding-top:25px">
                                            <tbody>
                                            <tr>
                                                <td style="font-family:Avenir,Helvetica,sans-serif">
                                                    <p style="font-family:Avenir,Helvetica,sans-serif; color:#74787E; line-height:1.5em; margin-top:0; text-align:left; font-size:12px">
                                                        If you’re having trouble clicking the "Verify Account" button, copy and paste the URL below into your web browser: <a href="{{ route('user.verifyemail', $email_token) }}" target="_blank" rel="noopener noreferrer" style="font-family:Avenir,Helvetica,sans-serif; color:#3869D4"></a><a href="{{ route('user.verifyemail', $email_token) }}" target="_blank" rel="noopener noreferrer" style="font-family:Avenir,Helvetica,sans-serif; color:#3869D4">http://localhost:8080/agraria-v2//password/reset/5d79ff4a5df9e1602ebd5e21bbe36a62317addbb09210e9a17d07658c4e19c2a</a></p>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-family:Avenir,Helvetica,sans-serif">
                            <table class="x_footer" align="center" width="570" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif; margin:0 auto; padding:0; text-align:center; width:570px">
                                <tbody>
                                <tr>
                                    <td class="x_content-cell" align="center" style="font-family:Avenir,Helvetica,sans-serif; padding:35px">
                                        <p style="font-family:Avenir,Helvetica,sans-serif; line-height:1.5em; margin-top:0; color:#AEAEAE; font-size:12px; text-align:center">
                                            © 2017 {{ env("APP_NAME") }}. All rights reserved.</p>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>
</div>