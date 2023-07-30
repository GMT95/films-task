<script>

export default {
    props: {
        comments: {
            type: Object,
            required: true
        },
        user: {
            type: Object,
            default: null
        },
        slug: {
            type: String,
            required: true
        }
    },
    data() {
        return {
            form: {
                text: "",
                errors: {
                },
                processing: false
            }
        }
    },
    methods: {
        async addComment() {
            try {
                this.form.processing = true;

                const response = await axios.post(`/api/v1/films/${this.slug}/add-comment`, this.form)

                const responseData = response.data.data;

                this.comments.unshift(responseData.comment);

                this.form.text = ""

                this.$notify({
                    title: "Success",
                    text: response.data.message,
                    type: 'success'
                });

            } catch (error) {
                if (error.response.status == 422) {
                    const { errors } = error.response.data.data
                    this.form.errors = errors
                } else {
                    this.$notify({
                        title: "Error",
                        text: "Something went wrong",
                        type: 'error'
                    });
                }
            } finally {
                this.form.processing = false;
            }

        }
    }
}
</script>

<template>
    <div class="antialiased mx-auto max-w-screen-sm mt-4">
        <h3 class="mb-4 text-lg font-semibold text-gray-900">Comments</h3>

        <div class="space-y-4">

            <div class="flex-1 border rounded-lg px-4 py-2 sm:px-6 sm:py-4 leading-relaxed" v-for="comment in comments"
                :key="comment.id">
                <strong class="mr-2">{{ comment.user.name }}</strong>
                <span class="text-xs text-gray-500">{{ new Date(comment.created_at).toDateString() }}</span>
                <p class="text-sm">
                    {{ comment.text }}
                </p>
            </div>

            <!-- Add comment form -->
            <div v-if="user" class="flex-1 border rounded-lg px-4 py-2 sm:px-6 sm:py-4 leading-relaxed">
                <form @submit.prevent="addComment">
                    <TextInput id="text" type="text"
                        class="form-input rounded border-gray-400 leading-normal resize-none w-full h-20 font-medium placeholder-gray-700 focus:outline-none focus:bg-white"
                        v-model="form.text" placeholder="Type Your Comment" required />

                    <InputError class="mt-2" v-if="form.errors.text" :message="form.errors.text" />

                    <PrimaryButton :class="`mt-4 bg-blue-600 ${form.processing ? 'opacity-50 pointer-events-none' : ''}`"
                        :disabled="form.processing">
                        Post Comment
                    </PrimaryButton>
                </form>
            </div>
            <div v-else class="flex-1 text-center border rounded-lg px-4 py-2 sm:px-6 sm:py-4 leading-relaxed">
                <PrimaryButton class="mt-4 bg-blue-600">
                    <a href="/login">
                        Login to Comment
                    </a>
                </PrimaryButton>
            </div>
            <!-- Add comment form -->

        </div>
    </div>
</template>
