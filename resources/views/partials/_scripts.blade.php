<!-- Backend Bundle JavaScript -->
<script src="{{ asset('js/backend-bundle.min.js') }}"></script>

<script src="{{ asset('js/raphael-min.js') }}"></script>

<script src="{{ asset('js/morris.js') }}"></script>
<script src="{{ asset('vendor/tinymce/js/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('vendor/confirmJS/jquery-confirm.min.js') }}"></script>

@auth    
   <script src="https://unpkg.com/mqtt/dist/mqtt.min.js"></script>

   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

   <audio id="myAudio">
      <source src="{{asset('sounds/notification.mp3')}}" type="audio/mpeg">
   </audio>

   <script>

      const newRideRequestedTopic = 'new_ride_requested';

      const client = mqtt.connect("ws://broker.hivemq.com/mqtt", { 
         port: 8000,
         clean: true,
         connectTimeout: 4000,
      });      

      // Evento cuando el cliente se conecta al broker
      client.on('connect', () => {

         // Suscribirse a un tema
         client.subscribe(newRideRequestedTopic, (err) => {
            if (!err) {
               //console.log(`Suscrito al tema ${newRideRequestedTopic}`);

               // Publicar un mensaje en el tema
               // const message = 'Nueva solicitud recibida';
               // client.publish(topic, message, (err) => {
               //    if (!err) {
               //       console.log(`Mensaje publicado: ${message}`);
               //    }
               // });
            }
         });
      });

      // Evento cuando se recibe un mensaje
      client.on('message', (topic, message) => {

         console.log(`Mensaje recibido en ${topic}:`);

         if (topic == newRideRequestedTopic) {

            const rideRequest = JSON.parse(message.toString());

            playAudio();

            Swal.fire({
               title: rideRequest.success_message,
               text: `Pasajero: ${rideRequest.result.rider_name} \n
                  Desde: ${rideRequest.result.start_address} \n
                  Hasta: ${rideRequest.result.end_address}
               `,
               icon: "warning",
               showCancelButton: true,
               confirmButtonColor: "#3085d6",
               cancelButtonColor: "#d33",
               confirmButtonText: "Ir a la solicitud"
               }).then((result) => {

               if (result.isConfirmed) {
                  location.href =  `{{url('/')}}/riderequest/${rideRequest.result.id}`;
               }

            });

         }
      });

      client.on('error', (err) => {
         console.error(`Error: ${err}`);
      });


      function playAudio() {

         var promise = document.querySelector('#myAudio').play();

         if (promise !== undefined) {
            promise.then(_ => {
               // Autoplay started!
            }).catch(error => {
               // Autoplay was prevented.
               // Show a "Play" button so that user can start playback.
            });
         }
      }

      function pauseAudio() {
         audio.pause();
      }

   </script>
@endauth

<script>

    // Text Editor code
      if (typeof(tinyMCE) != "undefined") {
         // tinymceEditor()
         function tinymceEditor(target, button, height = 200) {
            var rtl = $("html[lang=ar]").attr('dir');
            tinymce.init({
               selector: target || '.textarea',
               directionality : rtl,
               height: height,
               plugins: [ 'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview', 'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen', 'insertdatetime', 'media', 'table', 'help', 'wordcount' ],
               toolbar: 'undo redo | blocks | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help',
               content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }',
               automatic_uploads: false,
               /*file_picker_types: 'image',
               file_picker_callback: function(cb, value, meta) {
                  var input = document.createElement('input');
                  input.setAttribute('type', 'file');
                  input.setAttribute('accept', 'image/*');

                  input.onchange = function() {
                     var file = this.files[0];

                     var reader = new FileReader();
                     reader.onload = function() {
                        var id = 'blobid' + (new Date()).getTime();
                        var blobCache = tinymce.activeEditor.editorUpload.blobCache;
                        var base64 = reader.result.split(',')[1];
                        var blobInfo = blobCache.create(id, file, base64);
                        blobCache.add(blobInfo);

                        cb(blobInfo.blobUri(), { title: file.name });
                     };
                     reader.readAsDataURL(file);
                  };
                  input.click();
               }*/
            });
         }
      }
      function showCheckLimitData(id){
         var checkbox =  $('#'+id).is(":checked")
         if(checkbox == true){
            $('.'+id).removeClass('d-none')
         }else{
            $('.'+id).addClass('d-none')

         }
      }
</script>
@if(isset($assets) && in_array('map', $assets))
    <script src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_MAP_KEY')}}&libraries=drawing" defer></script>
@endif
@yield('bottom_script')

<!-- Masonary Gallery Javascript -->
<script src="{{ asset('js/masonry.pkgd.min.js') }}"></script>
<script src="{{ asset('js/imagesloaded.pkgd.min.js') }}"></script>

<!-- Vectoe Map JavaScript -->
<script src="{{ asset('js/vector-map-custom.js') }}"></script>

<!-- Chart Custom JavaScript -->
<script src="{{ asset('js/customizer.js') }}"></script>

<!-- Chart Custom JavaScript -->
<script src="{{ asset('js/chart-custom.js') }}"></script>

<!-- slider JavaScript -->
<script src="{{ asset('js/slider.js') }}"></script>

<!-- Emoji picker -->
<script type="module" src="{{ asset('vendor/emoji-picker-element/index.js') }}"></script>

@if(isset($assets) && (in_array('datatable',$assets)))
<!-- <script src="{{ asset('vendor/datatables/js/jquery.dataTables.min.js') }}"></script> -->
<!-- <script src="{{ asset('vendor/datatables/js/dataTables.bootstrap4.min.js') }}"></script> -->
<!-- <script src="{{ asset('vendor/datatables/js/dataTables.buttons.min.js') }}"></script> -->
<!-- <script src="{{ asset('vendor/datatables/js/buttons.bootstrap4.min.js') }}"></script> -->
<script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
<!-- <script src="{{ asset('vendor/datatables/js/dataTables.select.min.js') }}"></script> -->
@endif

<!-- app JavaScript -->
@if(isset($assets) && in_array('phone', $assets))
    <script src="{{ asset('vendor/intlTelInput/js/intlTelInput-jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/intlTelInput/js/intlTelInput.min.js') }}"></script>
@endif

<script src="{{ asset('js/app.js') }}" defer></script>
@include('helper.app_message')
