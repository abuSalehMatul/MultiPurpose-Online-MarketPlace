@extends('layouts.app') 
@section('title', 'Add Service') 
@section('content')
<div class="clearfix"></div>
<section class="inner-header-title blank">
        <div class="container">
            <h1>Add Service</h1>
        </div>
</section>
<div class="section detail-desc">
    <div class="container white-shadow">
        <form action="{{url('service/store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name"  placeholder="Name of your task">
                <small id="name" class="form-text text-muted">Named whatever your task is.</small>
            </div>
            <div class="form-group">
                <label for="name">Price</label>
                <input type="number" class="form-control" id="price" name="price"  placeholder="i.e $40">
                <small id="price" class="form-text text-muted">What's your budget?</small>
            </div>
            <div class="form-group">
                <label for="name">Delivery Time</label>
                <input type="number" class="form-control" id="price" name="delivery_day"  placeholder="10 Day">
                <small id="price" class="form-text text-muted">How many days you need for delivery</small>
            </div>
            <div class="form-group">
                <label for="name">Description</label>
               <textarea name="description" class="form-control" id="" cols="30" rows="10"></textarea>
                <small id="description" class="form-text text-muted">Description of your task.</small>
            </div>
            <div class="form-group">
                <label for="category">Category</label>
               <select name="category" class="form-control" id="category">
                    @php
                        $cat=App\ChoreCategory::all();
                    @endphp
                    @if($cat)
                        @foreach($cat as $cat)
                            <option value="{{$cat->id}}">{{$cat->name}}</option>
                        @endforeach
                    @endif    
                        <option value="-10">Other</option>
               </select>
            </div>
            <div class="form-group">
                <label for="image">Image</label>
               <input name="image" type="file" class="form-control" id="image" >
                <small id="image" class="form-text text-muted">Set a image .</small>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="precidance" id="exampleRadios1" value="1" checked>
                <label class="form-check-label" for="exampleRadios1">
                   Featured..[Charges Apply]
                </label>
                </div>
                <div class="form-check">
                <input class="form-check-input" type="radio" name="precidance" id="exampleRadios2" value="2">
                <label class="form-check-label" for="exampleRadios2">
                   Normal
                </label>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>
@endsection