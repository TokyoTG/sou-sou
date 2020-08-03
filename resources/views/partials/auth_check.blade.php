@php

   function is_admin(){
        return Cookie::get('role') !== null && Cookie::get('role') == "admin";
    }

    function is_member(){
        return Cookie::get('role') !== null && Cookie::get('role') == "member";
    }
@endphp