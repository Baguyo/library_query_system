


<div dir="ltr" style="background-color: #f7f7f7">
    <div
        style="color:rgb(0,0,0);font-family:&quot;Times New Roman&quot;;font-size:medium;width:130px;max-width:130px;min-width:100px;float:left;padding-top:15px">
        <img src="{{Storage::url('default/LIBRARYLOGOv2.png')}}"
            style="margin-top: 1.4em;margin-left:1.1em;width:90px;">
            
    </div>
    <div
        style="text-align: justify ;width:500px;max-width:500px;font-family:&quot;Lucida Grande&quot;,Tahoma;font-size:12px;margin-top:0.5em;color:rgb(102,102,102);letter-spacing:2px;border-left:2px solid rgb(211,216,215);padding-top:3px;padding-left:10px;overflow:hidden">
        <h3> Hello! {{$user->name}} we already created an account for you. To access the
            Library Query System use this login credentials. &nbsp;
            <br>
        </h3>
        <h4>Email address: {{$user->email}} &nbsp;
            <br>
            {{-- <a href="https://mdbootstrap.com/" style="margin-top:0.5em;color:rgb(102,102,102);text-decoration:none"
                target="_blank">mdbootstrap.com</a>
            &nbsp;<br> --}}
            Password: {{$password}}
        </h4>
        <p style="margin-top: 2rem"><a href="{{ route('home') }}"
                style="margin-top:0.8em;color:white;text-decoration:none; background-color:rgb(102,102,102);padding: 10px; border-radius: 5px " target="_blank">Login</a>&nbsp;
                {{-- <a
                href="https://twitter.com/MDBootstrap"
                style="margin-top:0.5em;color:rgb(102,102,102);text-decoration:none" target="_blank"><img
                    src="https://cdn3.iconfinder.com/data/icons/free-social-icons/67/twitter_circle_gray-24.png"></a>&nbsp;<a
                href="https://plus.google.com/+Micha%C5%82Szyma%C5%84skiBF/posts"
                style="margin-top:0.5em;color:rgb(102,102,102);text-decoration:none" target="_blank"><img
                    src="https://cdn3.iconfinder.com/data/icons/free-social-icons/67/google_circle_gray-24.png"></a> --}}
                </p>
        <p style="margin-top: 20px">
            Best regards, fbclibrary.com
        </p>
    </div>
    <div
        style="width:190px;max-width:190px;font-family:'Lucida Grande',Tahoma;font-size:12px;margin-top:0.5em;color:rgb(102,102,102);letter-spacing:2px;border-left-width:2px;border-left-style:solid;border-left-color:rgb(251,224,181);padding-top:3px;padding-left:10px;overflow:hidden">
    </div>
</div>
