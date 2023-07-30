<script>

export default {
    props: {
        comments: {
            type: Object,
            required: true
        },
    },
    data() {
        return {
            form: {
                text: "",
                errors: {
                },
                processing: true
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

            <div class="flex-1 border rounded-lg px-4 py-2 sm:px-6 sm:py-4 leading-relaxed">
                <form>
                    <textarea
                        class="form-input rounded border-gray-400 leading-normal resize-none w-full h-20 py-2 px-3 font-medium placeholder-gray-700 focus:outline-none focus:bg-white"
                        placeholder="Type Your Comment" required></textarea>

                    <InputError class="mt-2" v-if="form.errors.password" :message="form.errors.password" />

                    <PrimaryButton
                        :class="`mt-4 bg-blue-600 ${form.processing ? 'opacity-50 pointer-events-none' : ''}`"
                        :disabled="form.processing"
                    >
                        Post Comment
                    </PrimaryButton>
                </form>
            </div>

        </div>
    </div>
</template>
