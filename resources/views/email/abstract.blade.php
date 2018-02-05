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
                            <a href="{{ env('APP_URL') }}" target="_blank" rel="noopener noreferrer" style="font-family:Avenir,Helvetica,sans-serif; color:#bbbfc3; font-size:19px; font-weight:bold; text-decoration:none">{{ env("APP_NAME") }} </a></td>
                    </tr>
                    <tr>
                        <td class="x_body" width="100%" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif; background-color:#FFFFFF; border-bottom:1px solid #EDEFF2; border-top:1px solid #EDEFF2; margin:0; padding:0; width:100%">
                            <table class="x_inner-body" align="center" width="80%" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif; background-color:#FFFFFF; margin:0 auto; padding:0; width:570px">
                                <tbody>
                                <tr>
                                    <td class="x_content-cell" style="font-family:Avenir,Helvetica,sans-serif; padding:35px">
                                        <h1 style="font-family:Avenir,Helvetica,sans-serif; color:#2F3133; font-size:19px; font-weight:bold; margin-top:0; text-align:left">
                                            Hello {{ $submission->user->name }} !</h1>
                                        <p style="font-family:Avenir,Helvetica,sans-serif; color:#74787E; font-size:16px; line-height:1.5em; margin-top:0; text-align:left">
                                            Congratulation ! Your abstract has been approved, please continue to the payment. Here is your payment detail :
                                        </p>
                                        <table class="x_action" align="center" width="100%" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif; margin:30px auto; padding:0; text-align:center; width:100%">
                                            <tbody>
                                            <tr>
                                                <td align="center">
                                                    <table width="90%">
                                                        <tbody>
                                                        <tr>
                                                            <td>{{ $submission->submission_event->parent->name }} | {{ $submission->submission_event->name }}</td>
                                                            <td align="right">
                                                                @if($submission->user->personal_data->islocal != 0)
                                                                    IDR {{ $submission->payment_submission->pricing->price }}
                                                                @else
                                                                    USD {{ $submission->payment_submission->pricing->usd_price }}
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <p style="font-family:Avenir,Helvetica,sans-serif; color:#74787E; font-size:16px; line-height:1.5em; margin-top:0; text-align:left">Please make payment to the following account number:</p>
                                        <table>
                                            <tbody>

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