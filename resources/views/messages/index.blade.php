@extends('layouts.master')

@section('breadcrumbs')

@endsection

@section('content')

    <section>
        <br>
        
        <div class="box"> 
            <div class="level">
                <category-filter-component></category-filter-component> 
            </div>
        </div>

        <messages-overview-component></messages-overview-component>
    </section>
    
@endsection
