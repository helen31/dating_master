@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                        {!! csrf_field() !!}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}">

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password">

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password_confirmation">

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i>Register
                                </button>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-3 col-md-offset-3"><a href="/social/redirect/facebook"><img width="64px" src="data:image/png;base64,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"></a></div>
                            <div class="col-md-3"><a href="/social/redirect/google"><img width="64px" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAIAAAACACAYAAADDPmHLAAAPiUlEQVR4Xu2deXQURR7Hv9VzZgKESYiTAAECcrq6LkRBN2pAH2eIiCKwgHjiuuKx8lQUxXCJgqAc8tzVh+yCChh1QYiuvphwLETiCqKGJGQSwhUJJBwhd6Z7Xw1v2BwzmeqZ7p6eSXf+yXvzq6pf/b6frqquqq4m8HIJACkamzSEEEwQOOE2wpOuAuFjCbhwb2m13xWNQAMgnIcgHAXHZRMBO3olJO0mqal8W14QTz8KqancsZys+wVgEQiuVbQqWmGSRIAQh12Abmm8OXoD+fRTh7tM3QJQmJJ0LdeIj8HhJkk80TIJbAQIfgAh03tvz8xv6UgrAArHjxgBgU/jAGtgvdZKlzQCAi4TkPvid2b+u2m+zQCg4nMCTw30khauZaaWCDQAXHLvHd9943LoKgC02QePA9qdrxatZPJDwGVB0A3pk55RQEtwAkAHfMUHsrK1Pl+moKsuW+FAfMLwW+gTghOA4nFJUwSCT1Tnp+aQbBEgAh6M35n1D0Kf84vHJRVoj3qyxVqlGQsF8Tt2DSD2sUkJhEOOSr3U3JIxAjxHEknRuKTFIJgnYzla1iqNAAFZSuzj79hFBHK7Sn3U3JI3Alm0BTiq9f/yRlmtufMO4TSxJ99+WVvYUatE8vrF86ghRclJgrzFaLmrNQI8zzs0ANSqjgJ+aQAoEGQ1F6EBoGZ1FPBNA0CBIKu5CA0ANaujgG8aAAoEWc1FaACoWR0FfNMAUCDIai5CA0DN6ijgmwaAAkFWcxEaAGpWRwHfNAAUCLKai9AAULM6CvimAaBAkNVchAaAmtVRwDcNAAWCrOYiNADUrI4CvmkAKBBkNRehAaBmdRTwLWgB4CwWGOJ6Qh9tgy6iszNUQl0dHJcr4bhwHo1nz8BRUQ4I2nbHtjgKGgA4cxjCEoYibMjNMA+6Hoau3b3eHxSIhpPHUVdciLqCPNT+8hMaTpR4TdeeDFQPgPm6G9BxbArChyWCGE1+a+MoP4fqnP2o2pOJmp8PtfsWQrUA0DvdOvVBmPoP9Ft0Txk0lv2GS19tR2X6NvDV1bKVo+aMVQeAIbYbov78DMIGK3c0EV9VhQtpH+HStjQIDQ1q1kty39QDACGISLkP1gceBTEaJa8oS4Z0fFC2Ygnq7UdZzEPCRhUAcOEdED1nHiw3DQt4UIX6epx9eymq9mYF3BclHAg4AHpbLGIWLIOhm/dRvRIBcZbB8yhbvqhdQBBQAOhzfOziFdBFRimmLWtBQn0dTjz5MBy/nWZNEpR2AQOAPsfHvrkaus7qPIqweO3bOJq2GT0sZph0XFCKy+J0QACgM3ddV6wDbf7VeBWtXYG8rZtB5xB1HIdeIQyB4gAQnQ4xS1aCTvCo8Woqvsu/UIZAcQAiZ85CxH1TJdO+MvdXXMjZh8rCo6gtO4P6y5UQGh0geh3MVis69R+E2JSJCOsZ77XMojUrkPfplTu/5RWqECgKAJ3Dj31jFUA8HlDuVSRqULZzG45/vhUVxUVoaGz0moaW1tlmQ//ZzyHqjhFu7dsSP5RbAsUAIHo9uq1dD0O3OK+CeTI4/uH7sG/ZhGofp20JIYjpPwA3LF8DfUTE1WLsq99CftoWt3d+qLcEigEQMXEKIh963CfxqwoLcPD5Z3Cx/JxP6VsmMhtNuPHVhc7WQIz4odgSKAIAFx6OuA8+Adeho2gBSz/7BIfXrEIj7/ZbB6LzcyUgIIjuHY+zRUVMd36otgSKANB58gxYpz8sWqyS99fh100bIKh0U4c/A8NeaV8DXPP5hdxnn4C5xA7OvyGSqDjLDgDt++M+3Cp6wud02ic4tOZt1Yrvb3cQvy2jFQDf/+keVJeeRo9wi2IQyA5AeGISrnnxNVFUXs4/gv88/iAa+Ta/dSQqTzmNfWkJPAFw7uRJWHScYhDIDoBt/lLRq3x77h6FS+cr5NRM8rzFQtAWANQ5pSCQFQC6cbPHR9tAuwHWi/b7v2z8kNVcVXZiIPAGgFIQyAqAZVgibPMWsYvE88gYfQdqa2vZ06jMkhUCFgCUgEBWAKIem41OKfcyS1T6+Vb8+M5yZnu1GrJAwAqA3BDICkDX5WthGnAds04HZk7B2WI7s707Q6vNBuug3/mVB2vii4UFKD9xopU5nem2hFnQK6479B66v+7rNrSaEj/45CMoL8hzW3y4xQKbjoBIvGdRVgB6bt0JLszCGk98M2IYGhr9m/DpPfxODFzwBnOZ/hie2rIRh95d3SoLS4cOGJ6e6U/WbtNmTxiJ6MYGSR8RZQNAZ41Ej39+xhyEyrxc7J41k9nek6GSAFTszcL+l59XDICMkYngGhokfUSUDQBT3/7ouvI9ZkFPbdqAQ39/l9leDQB4glauFoACUFtbJ+kjomwAhP0hATEL2Qd0R996HQXbvwgqAKpLipE5435FWwAKgJQDQ9kAsAz9I2yvLGYWNG/BPNgzrn7NlDldS0Mlu4Ca48fw3fRJAQFAKghUA0D+4vko/OYrn4V3JVQSAE9dAEcIzBbPg19bjA2D1m9u9RRw+NknUJ5/xGMMaqqrWr3s7O+MoWwAhN2YgJhF7F1A8bpVyN28KagAqNi3B/vnPueTz2O/299qhpQuBtG1ALGXPxDIBoDYQWDZt+nIWSRu0chdoJRsAeiK5cHVK8Xq5bQfm7EPxGBoltZXAPzpDmQDQOxjIF9bi69H3eb3eQ5KAuDPwFVqAHyFQDYAqEM9t+wEXRBivfZMGIVLFf6tAtr69kOPifdD39kKgzUSxshIGCK7gJPhhdOfnpqFkz8dZK1eMzs5APAFAlkBiF22BuaB7NOyBW8sxNH0L30KqLdEdGBGOA56TgedQQ+dwQCd0Qid0Qx9mBm6sDAYLBYMXLjM+T/LtXfiGFw859s+RbkAEAuBrADQTaB0MyjrVX++HBn3jAHPB+ZcHwrJaDo40+mYXP56+DA4HL5NXbsD4IeHpuKMvZCpbG9GrANDWQGgp3zEpL7pzddmvx+a/QhOHT4sKo1UxhFdopH4eTpTdhdzsrF3zlNMtu6M3AGQPW0iakpPo9rP9RBXeSwQyAoAPeih58fbQUzsZ/vU/XYamVPugSMA28F+/8RT6D71ASZRj7w2F0WZGUy27ozc7ft0tXsWvU4xCGQFgFaczgbSWUExl33FG8jbxr6QJCZvT7adoqJw2xdfM2e1e/xdqLx4kdlerKFSEMgOgOWW22B7eaHY+mP/5LtRUarMu/l6jkPiBxsRfm0/Jj/piyq7Hpku+45lJSCQHQA6oHJuC7dGMgXXZdR44Tz2TJng82tgrIXRgV/C3FcQPSaFNQl+eeFplGTvZ7b3x1BuCGQHgFa+86RpzsOfxF61p09i30NTUVMjzx5BKv6NT89B7L2TmV3j6+ud+xbrGV5KZc7Ui6GcECgCAN0VFLd+s0+vhtWfO4fvH5uGS+X+TRC1jLFRr8fgVxcjavidonQqXPkm8v+VJiqNFMZyQaAIADQAEXdPQuSjf/EtFjyP3PkvomTPLvASvCZG9w0OXvUezAzHzTZ1mE5XZySPQH19YM4SlAMCCLyDFCUnyT7zQscCXVe9DyPDQQ2eKKn89Wf8+vprbjdispBlNpvQb9pMxM18jMW8lU3uqy+geJf0e/3EOCM1BN3MJmUAoJU09RuA2GVrmWfa2gLh2Pq/oezwT6ita3t8YDQaYO3ZCzF3jUb3ydNbvY/HGvyqgnzsnjUjYLOUTf2UEgKTjhMUaQFcFeh8/zRYZ4gfEHoSqqakGBV7d6OyMB/1Fy+Ar68DZzTB0j0OtlHJ6Hjd9awat2m3954xkp1PIIVDUkFAJ6QUBYAeD2N7aQHo/ECwXEcWvIyijG9V564UECgPACXOZELs0lWgm0bUfpV+tgU/rn4LPp0ioUDl/IUgIADQuHAdOzpPCTX27qtAmHwrgu77P/DKiwFZlxDjsT8QBAwAFwQx85eKen1MTGD8saX7/XLmPY9GH5d7/Snbl7S+QhBQAGhF6Yqh9Ym/IuKu0b7UW5Y0ZenbcXDZkqA5oMIVBF8gCDgA1Hk6uUOGDEWvlxaAM5tlEZU108KVS1Gw7XO/9yaylie1nVgIVAHAFQiAcoMRvWc9jS5jxkkdF6/50X0IB+fM9nmSyWsBChqIgUA1ALggOF5dg/BucRg4d75kz/Btxp7nUfjOcti//CJo+nsWllghUBUAVyGoqkY1zyO6Ry/0fvAxdLlzJEudRdkIjY0oef9d2L9IC+oTSdqqNAsEqgOgGQSOK6eEmcMsiBk8BF3vnQxrwlBRQrc0po92Jz79GGU//6zokq5fTvuR2BsEqgTAHQSuGNATNzrZbOjUpy869h+ITgOuQ1h8PExdrmkWJkd1FaqPHUNl7mFcyv0FF/KPoLK0tF2I3pKXtiBQLQBtQeDphqAbPOgl0D/Z1zf9uC0DkNQTBKoGwBcIAhDboCnSHQSqB0CDQFq+WkIQFAC4ICipqkFNkEzNSiubtLk1hSBoANAgkAeCoAJAg0B6CGro95WU2BMopet02ljrDqSJaJhOp+yWMGncvrJ2oEHgfzSDrgtoWmUNgnYOgDYm0ABwRkBrCXwHIai7AK078F14V8qQAUBrCXyDIaQA0CAQD0HIAXAVguoa0EkO7Wo7AiEJgAYBO/YhC4AGARsEIQ2ABoF3CEIeAA2CdjoGaFlt52SRNjBsRUO7aAFctdYgaN0auACoB9D88Hrv3UdQWmgQNJctymRoIEXJd5wBSPN91UEpL5vTGgRX4nSN2Ygok/4UKRp3+14QTtx5rmyxVq1Ve4eAit/FZIRAkEmKxie9BQFzVKuWTI7Rt5JLqmvb3YyhS3xnWAUsIcXJSfScuMCefyaTyN6ybW8QNBOfntQC4VYipKZyx/6bUSAIuj7eAhaKv7cXCFqK7+CRd2161iDn+1RF45MegYAPQlFgljqFOgQtxXfGhAgP9P5y10YnAMKkSbri2rPZEJDAErBQtAlVCNyK78D++KFJiSQ1lb/68YqilOH94RB+AEGHUBSYpU6hBoFb8SFccjh0g/t+9Z3d2RA0DUzxuOGjBCLQT3e1i4khd1CECgRuxeeFeoHjxvbZ8f/v3TQDwDkeSB4xEgL/mdYSBO8joqc7XwA3san4rVoA1x1hH3tnP8I1bgTIzSxNZyjaBGtL4KnPd4Cb4Wr2m+rVqgVw/eh8PMzJmiEQ4WWAsH1QJ8RICDYI3D3q6QiWxN+U9DEd8LmTxyMAV0EAiD1l+K06HuMECLfwDqEfCLECvDHE9HZbHYfA40RNA1fncHiNVSDjEWkyNFxjNpSBcAWExz6OCDt77tiVTbycdPw/zcjPTTm/YE4AAAAASUVORK5CYII="></a></div>
                            <div class="col-md-3"><a href="/social/redirect/twitter"><img width="64px" src="data:image/png;base64,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"></a></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
