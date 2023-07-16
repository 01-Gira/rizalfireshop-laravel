@if (session()->has('flash_notification.message'))
  {{-- <div class="container"> --}}
    <div id="alertContainer" class="alert alert-dismissible alert-{{ session()->get('flash_notification.level') }}">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      {!! session()->get('flash_notification.message') !!}
    </div>
  {{-- </div> --}}
@endif

@if (session()->has('sweet_alert.title'))
    <script>
	@if (session()->has('sweet_alert.timer'))
		 Swal.fire({
			icon: '{!! session()->get('sweet_alert.icon') !!}',
			title: '{!! session()->get('sweet_alert.title') !!}',
			text: '{!! session()->get('sweet_alert.text') !!}',
			timer: '{!! session()->get('sweet_alert.timer') !!}',
			showConfirmButton: '{!! session()->get('sweet_alert.showConfirmButton') !!}'
		}).catch(swal.noop);
	@else
		Swal.fire({
			icon: '{!! session()->get('sweet_alert.icon') !!}',
			title: '{!! session()->get('sweet_alert.title') !!}',
			text: '{!! session()->get('sweet_alert.text') !!}'
		});
	@endif
    </script>
@endif