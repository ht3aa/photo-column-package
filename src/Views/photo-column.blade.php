@php
    $photoUrl = asset("/storage/{$getState()}");
@endphp

<style>
    .fade-in-out {
        animation: fade-in-out 1s linear infinite;
    }

    @keyframes fade-in-out {
        0% {
            background: rgba(0, 0, 0, 0.3);
        }

        50% {
            background: rgba(0, 0, 0, 0.7);
        }

        100% {
            background: rgba(0, 0, 0, 0.3);
        }
    }
</style>

<div x-data="{
    photoUrl: @js($photoUrl),
    name: @js($getName()),
    recordKey: @js($recordKey),
    progress: 0,
    startUploading: false,
    uploadingFailed: false,
    updateProgress: (progress) => {
        $refs.progressBar.style.width = progress + '%';
        $refs.progressText.innerText = progress + '%';
    }
}">

    <div x-ref="progressBar" style="width: 0%; height: 2px; background-color: green"></div>

    <template x-if="progress === 0 && uploadingFailed">
        <div x-ref="failed" style="width: 100%; height: 2px; background-color: red"></div>
    </template>

    <template x-if="photoUrl">
        <div class="flex justify-center items-center mb-2">
            <div class="relative">
                <div class="flex absolute justify-center items-center w-full h-full text-lg opacity-100 z-[2]"
                    x-ref="progressText"></div>
                <img x-ref="photo" :src="photoUrl"
                    onerror="this.src='{{ asset(config('photo-column.defaultImgUrl')) }}';" style="height: 2.5rem; ">
            </div>
            <div class="cursor-pointer" style="margin-right: 8px" x-ref="editButton" @click="$refs.fileInput.click()">
                <span
                    class="flex relative gap-1 justify-center items-center outline-none fi-link group/link fi-size-sm fi-link-size-sm fi-color-custom fi-color-primary fi-ac-action fi-ac-link-action">
                    <svg style="--c-400:var(--primary-400);--c-600:var(--primary-600);"
                        class="w-4 h-4 fi-link-icon text-custom-600 dark:text-custom-400"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"
                        data-slot="icon">
                        <path
                            d="m5.433 13.917 1.262-3.155A4 4 0 0 1 7.58 9.42l6.92-6.918a2.121 2.121 0 0 1 3 3l-6.92 6.918c-.383.383-.84.685-1.343.886l-3.154 1.262a.5.5 0 0 1-.65-.65Z">
                        </path>
                        <path
                            d="M3.5 5.75c0-.69.56-1.25 1.25-1.25H10A.75.75 0 0 0 10 3H4.75A2.75 2.75 0 0 0 2 5.75v9.5A2.75 2.75 0 0 0 4.75 18h9.5A2.75 2.75 0 0 0 17 15.25V10a.75.75 0 0 0-1.5 0v5.25c0 .69-.56 1.25-1.25 1.25h-9.5c-.69 0-1.25-.56-1.25-1.25v-9.5Z">
                        </path>
                    </svg>

                    <span
                        class="text-sm font-semibold text-custom-600 dark:text-custom-400 group-hover/link:underline group-focus-visible/link:underline"
                        style="--c-400:var(--primary-400);--c-600:var(--primary-600);">
                        تغيير
                    </span>
                </span>

            </div>

            <!-- <template x-if="startUploading"> -->
            <!--     <div style="margin-right: 8px"> -->
            <!--         <span>جاري التحميل...</span> -->
            <!--     </div> -->
            <!-- </template> -->

            <input id="photo" class="overflow-hidden absolute w-0 h-0 opacity-0" type="file" accept="image/*"
                x-ref="fileInput"
                @change="
                          uploadingFailed = false;
                          startUploading = true;

                          // get the photo element (img element above)
                          const photo = $refs.photo;

                          // get progress text
                          const progressText = $refs.progressText;

                          // get the eidt button element (span element above)
                          const editButton = $refs.editButton;

                          // get the file from the file input element element (input element above)
                          const file = $refs.fileInput.files[0];

                          // add fade animation to photo element and hidden the edit button
                          progressText.classList.add('fade-in-out');
                          editButton.style.display = 'none';

                          // upload the file to photo public property in the ListUsers page
                          $wire.upload('photo', file, (uploadedFilename) => {
                              startUploading = false;
                              console.log('File uploaded:', uploadedFilename);

                              // after uploading done remove the animation and return the edit button back
                              progressText.classList.remove('fade-in-out');
                              editButton.style.display = 'block';

                              // add a preview url to the photo element
                              const reader = new FileReader();
                              reader.readAsDataURL(file);
                              reader.onload = (e) => {
                                  photoUrl = e.target.result;
                              };

                              // update the photo in the database
                              // name = column name (photo)
                              // recordKey = row id in the table
                              $wire.updatePhoto(name, recordKey);
                          }, (err) => {
                              // if something went wrong do the following
                              uploadingFailed = true;
                              startUploading = false;
                              $refs.progressBar.style.width = '0%';
                              progressText.classList.remove('fade-in-out');
                              progress = 0;
                              console.log('File upload failed', err);
                          }, (event) => {


                              // on uploading call the updateProgress function
                              // which is defined in x-data attribute above
                              updateProgress(event.detail.progress);
                          });
                      ">
        </div>
    </template>
</div>
