<template>
    <jet-form-section @submitted="addProduct">
        <template #title>
            Create a product
        </template>

        <template #description>
            Add an image, name (for internal use), title (to be displayed), description &amp; price.
        </template>

        <template #form>
            <!-- Profile Photo -->
            <div class="col-span-6 sm:col-span-4">
                <!-- Profile Photo File Input -->
                <input type="file" class="hidden"
                            ref="photo"
                            @change="updatePhotoPreview">

                <jet-label for="photo" value="Photo" />

                <!-- Current Profile Photo -->
                <div class="mt-2" v-show="! photoPreview">
                    <img :src="'https://picsum.photos/seed/picsum/300/300'" :alt="'Add your image'" class="h-60 w-60 object-cover">
                </div>

                <!-- New Profile Photo Preview -->
                <div class="mt-2" v-show="photoPreview">
                    <span class="block h-60 w-60" ref="photoPreview"
                          :style="'background-size: cover; background-repeat: no-repeat; background-position: center center; background-image: url(\'' + photoPreview + '\');'">
                    </span>
                </div>

                <jet-secondary-button class="mt-2 mr-2" type="button" @click.prevent="selectNewPhoto">
                    Select A New Photo
                </jet-secondary-button>

                <jet-input-error :message="form.errors.photo" class="mt-2" />
            </div>

            <!-- Name -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="name" value="Name" />
                <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" autocomplete="name" />
                <jet-input-error :message="form.errors.name" class="mt-2" />
            </div>

            <!-- Title -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="title" value="Title" />
                <jet-input id="title" type="text" class="mt-1 block w-full" v-model="form.title" />
                <jet-input-error :message="form.errors.title" class="mt-2" />
            </div>

            <!-- Description -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="description" value="Description" />
                <jet-input id="description" type="text" class="mt-1 block w-full" v-model="form.description" />
                <jet-input-error :message="form.errors.description" class="mt-2" />
            </div>

            <!-- Price -->
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="price" value="Price" />
                <jet-input id="price" type="text" class="mt-1 block w-full" v-model="form.price" />
                <jet-input-error :message="form.errors.price" class="mt-2" />
            </div>
        </template>

        <template #actions>
            <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                Saved.
            </jet-action-message>

            <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Save
            </jet-button>
        </template>
    </jet-form-section>
</template>

<script>
    import JetButton from '@/Components/Button'
    import JetFormSection from '@/Components/FormSection'
    import JetInput from '@/Components/Input'
    import JetInputError from '@/Components/InputError'
    import JetLabel from '@/Components/Label'
    import JetActionMessage from '@/Components/ActionMessage'
    import JetSecondaryButton from '@/Components/SecondaryButton'

    export default {
        components: {
            JetActionMessage,
            JetButton,
            JetFormSection,
            JetInput,
            JetInputError,
            JetLabel,
            JetSecondaryButton,
        },

        props: ['user'],

        data() {
            return {
                form: this.$inertia.form({
                    _method: 'POST',
                    name: 'Name (for internal use)',
                    title: 'Title (to be displayed)',
                    description: 'Your product description',
                    price: 99,
                    photo: null,
                }),

                photoPreview: null,
            }
        },

        methods: {
            addProduct() {
                if (this.$refs.photo) {
                    this.form.photo = this.$refs.photo.files[0]
                }

                this.form.post(route('addProduct'), {
                    errorBag: 'addProduct',
                    preserveScroll: true,
                    onSuccess: () => (this.clearInputs()),
                });
            },

            selectNewPhoto() {
                this.$refs.photo.click();
            },

            updatePhotoPreview() {
                const photo = this.$refs.photo.files[0];

                if (! photo) return;

                const reader = new FileReader();

                reader.onload = (e) => {
                    this.photoPreview = e.target.result;
                };

                reader.readAsDataURL(photo);
            },

            clearInputs() {
                this.$refs.photoPreview.style.backgroundImage = `url('https://picsum.photos/seed/picsum/300/300')`;
                this.form.reset()
            },
        },
    }
</script>
