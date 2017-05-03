@extends('layouts.guest')

@section('title', 'About | Ping the People')

@section('content')

@include('shared.guest-header')

<div class="container">
    <div class="primo-content">

        <h1 class="section-title">About</h1>

        <p>
        Ping the People is a free and <a href="https://github.com/pingthepeople">open source</a> project built with love by two Bloomington citizen-nerds, <a href="https://twitter.com/johnhoerr">John Hoerr</a> and <a href="https://twitter.com/ohnoitsaustin">Austin Lord</a>. We are dedicated to the proposition that it should be easy for Hoosiers to keep tabs on what's happening in the Indiana Statehouse. If you have any questions or comments, please email us at <a href="mailto:help@pingthepeople.org?Subject=Question/comment" target="_top">help@pingthepeople.org</a> or tweet us @pingthepeople.
        </p>

        <p>
        Ping the People is not affiliated with any political party or company. While the service is available free of charge, we're happy to accept <a href="/support">donations</a> via PayPal to help cover the cost of running the site. If you want to contribute to the software development effort, please <a href="mailto:help@pingthepeople.org?Subject=Open%20source" target="_top">get in touch</a>!
        </p>

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
                <em>Logo:</em><br/> 
                <a href="http://levimcg.com/">Levi McGranahan</a>
            </p>
        </small>

    </div>
</div>

@endsection