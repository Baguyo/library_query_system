<x-mail::message>
    Hello! {{ $transaction->user->name }} The Book {{ $transaction->book->name }} you borrowed must be returned before
     the closing time of the library. Otherwise you will be in penalty.  

{{-- <x-mail::button :url="''">
Button Text
</x-mail::button> --}}

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>


{{-- <div dir="ltr" style="background-color: #f7f7f7"> <div style="color:rgb(0,0,0);font-family:&quot;Times New Roman&quot;;font-size:medium;width:130px;max-width:130px;min-width:100px;float:left;padding-top:15px"> <img src="{{Storage::url('default/LIBRARYLOGOv2.png')}}" style="margin-top: 1.4em;margin-left:1.1em;width:90px;"> </div> <div style="text-align: justify ;width:500px;max-width:500px;font-family:&quot;Lucida Grande&quot;,Tahoma;font-size:12px;margin-top:0.5em;color:rgb(102,102,102);letter-spacing:2px;border-left:2px solid rgb(211,216,215);padding-top:3px;padding-left:10px;overflow:hidden"> <h3> Hello! {{$transaction->user->name}} The book you borrowed {{$transaction->book->name}} must be returned before the closing time of the library. Otherwise you will be in penalty. &nbsp; <br> </h3> <p style="margin-top: 20px"> Best regards, fbclibrary.com </p> </div> <div style="width:190px;max-width:190px;font-family:'Lucida Grande',Tahoma;font-size:12px;margin-top:0.5em;color:rgb(102,102,102);letter-spacing:2px;border-left-width:2px;border-left-style:solid;border-left-color:rgb(251,224,181);padding-top:3px;padding-left:10px;overflow:hidden"> </div> </div> --}}