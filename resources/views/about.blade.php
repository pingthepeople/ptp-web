@extends('layouts.guest')

@section('title', 'About | Ping the People')

@section('content')

@include('shared.guest-header')

<div class="content-wrapper">
    <div class="primo-content">

        <h1 class="section-title">About</h1>

        <p>
        <em>Ping the People</em> is a free and 
        <a href="https://github.com/pingthepeople">open source</a> 
        project built with love by two Bloomington citizen-nerds, 
        <a href="https://twitter.com/johnhoerr">John Hoerr</a> and 
        <a href="https://twitter.com/ohnoitsaustin">Austin Lord</a>. We are 
        dedicated to the proposition that every person and organization working 
        for positive change in Indiana should have access to timely information 
        about legislation that matters to them. If you have any questions or 
        comments, please email us at 
        <a href="mailto:help@pingthepeople.org?Subject=Question/comment" target="_top">help@pingthepeople.org</a>.
        </p>

        <p>
        <em>Ping the People</em> is not affiliated with any political party or company. 
        While the service will always be free to use, it costs about $75 a month
        to run, even when the Assembly isn't in session. If you value <em>Ping the People</em>
        and are able to do so, please consider making a contribution via the PayPal
        <em>Donate</em> button below.
        </p>

        <div class="u-flex">
            <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
                <input type="hidden" name="cmd" value="_s-xclick">
                <input type="hidden" name="hosted_button_id" value="P459Y9V79JUP8">
                <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
            </form>
        </div>

        <hr>

        <small>
            <p>
            We would like to thank the following people for their invaluable contributions to the creation of Ping the People. None of this would have been possible without their generous help, support, and patience.
            </p>	        
            <p>
                <em>Concept Development and Beta Testing:</em><br/> 
                <a href="http://bmclwv.org/">Kate Cruikshank</a>, <a href="http://www.btccbloomington.org/">Georg'ann Cattelona</a>, <a href="http://www.btccbloomington.org/">Allison Zimpfer-Hoerr</a>, <a href="https://twitter.com/emcorturillo">Emily Corturillo</a>, <a href="http://indiana.academia.edu/DanHassoun">Dan Hassoun</a></p>
            <p>
                <em>Design:</em><br/> 
                <a href="https://twitter.com/MadGrds">Madeline Grdina</a>, <a href="http://levimcg.com/">Levi McGranahan</a>, Alan Milner
            </p>
            <p>
                <em>Logo and Printed Materials:</em><br/> 
                <a href="http://levimcg.com/">Levi McGranahan</a>
            </p>
        </small>

    </div>
</div>

@endsection