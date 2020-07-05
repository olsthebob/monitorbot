@extends('layouts.app')

@section('content')

@php
  $route = route('create_test');
@endphp

<main class="main" id="app">

  <nav aria-label="breadcrumb">
    <div class="container">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Sites</a></li>
        <li class="breadcrumb-item active">{{ $site->name }}</li>
      </ol>
    </div>
  </nav>

  <section class="slice slice-md pt-3 border-bottom">
    <div class="container">
      <div class="row">
        <div class="col-lg-6">
          <h2>{{ $site->name }}</h2>
          <a href="{{ $site->site_url }}" target="_blank">{{ $site->site_url }}</a>
        </div>
      </div>
    </div>
  </section>

  <div class="container position-relative">
    <button type="button" class="addButton btn btn-primary position-absolute right-0" data-toggle="modal" data-target="#new_test_modal">
      <span class="btn-inner--icon">
        <i class="fas fa-plus mr-1"></i> New Test
      </span>
    </button>
  </div>

		<section class="slice slice-lg">
			<div class="container">

				<div class="row justify-content-center">
					<div class="col-lg-8">

            <h3 class="heading h5 mb-4">Tests</h3>

            <test-feed :tests="{{ $tests }}"></test-feed>
				
					</div>
				</div>

			</div>
		</section>

    <!-- MODAL -->
    <div class="modal modal-fluid fade" id="new_test_modal" tabindex="-1" role="dialog" aria-labelledby="new_test_modal" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <div class="row justify-content-center">
              <div class="col-lg-8 text-center pt-4 pb-0">
                <h4 class="heading h3">Create a new test</h4>
                <p class="lead text-muted">
                  Track and test elements of your website:
                </p>
              </div>
            </div>
            <div class="row justify-content-center">
              <div class="col-lg-8 pt-4 pb-4">
                <div class="py-1">
                  <new-test-form route="{{$route}}" :site="{{$site}}"></new-test-form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

	</main>
@endsection