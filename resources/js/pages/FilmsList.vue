<script>
import GuestLayout from '@/layouts/GuestLayout.vue';
import InputError from '@/components/InputError.vue';
import InputLabel from '@/components/InputLabel.vue';
import PrimaryButton from '@/components/PrimaryButton.vue';
import TextInput from '@/components/TextInput.vue';
import Spinner from '@/components/Spinner.vue';
import axios from "axios";

export default {
    components: {
        InputError,
        InputLabel,
        PrimaryButton,
        TextInput,
        GuestLayout,
        Spinner
    },
    async mounted() {
        await this.fetchFilms();
    },
    data() {
        return {
            films: null,
            pagination: null
        }
    },
    methods: {
        async fetchFilms(page = 1) {
            try {
                const response = await axios.get('/api/v1/films', { params: { page } })
                const responseData = response.data.data

                this.films = responseData.films;
                this.pagination = {
                    current_page: responseData.current_page,
                    total: responseData.total,
                    total_pages: responseData.total_pages,
                }

                console.log(response, 33)
            } catch (error) {
                alert("Something went wrong")
            }
        }
    }
}
</script>

<template>
    <GuestLayout>

        <PrimaryButton class="mb-4">
            <a href="/films/create">Add Film</a>
        </PrimaryButton>

        <div v-if="films">
            <film-card
                v-for="film in films"
                :key="film.id"
                :film="film"
                link
            ></film-card>

            <div v-if="pagination">
                <PrimaryButton
                    :class="`mt-4 mr-2 bg-blue-600 ${this.pagination.current_page == 1 ? 'opacity-50 pointer-events-none' : ''}`"
                    @click="fetchFilms(this.pagination.current_page - 1)">
                    Prev
                </PrimaryButton>

                <PrimaryButton
                    :class="`mt-4 ml-2 bg-blue-600 ${this.pagination.current_page == this.pagination.total_pages ? 'opacity-50 pointer-events-none' : ''}`"
                    @click="fetchFilms(this.pagination.current_page + 1)">
                    Next
                </PrimaryButton>
            </div>
        </div>
        <div v-else>
            <Spinner></Spinner>
        </div>

    </GuestLayout>
</template>
