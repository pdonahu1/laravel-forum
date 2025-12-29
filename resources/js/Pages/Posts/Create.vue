<template>
    <AppLayout title="Create a Post">
        <Container>
            <h1 class="text-2xl font-bold">Create a Post</h1>

            <form @submit.prevent="createPost" class="mt-6">
                <div>
                    <InputLabel for="title" class="sr-only">Title</InputLabel>
                    <TextInput id="title" type="text" class="mt-1 block w-full" v-model="form.title" placeholder="Give it a great title..." />
                    <InputError :message="form.errors.title" class="mt-1"/>
                </div>

                <div class="mt-3">
                    <InputLabel for="body" class="sr-only">Body</InputLabel>
                    <MarkdownEditor v-model="form.body">

                        <template #toolbar="{ editor }">
                            <li>
                        <button @click="autofill"
                        type="button" 
                        class="px-3 py-2"
                        title="Autofill">
                        <i class="ri-article-line">
                        </i>
                    </button>
                </li>
                        </template>

                    </MarkdownEditor> 
                    <InputError :message="form.errors.body" class="mt-1" />
                </div>

                <div class="mt-3">
                    <PrimaryButton type="submit">Create Post</PrimaryButton>
                </div>
            </form>
        </Container>
    </AppLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import MarkdownEditor from '@/Components/MarkdownEditor.vue';
import Container from '@/Components/Container.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextArea from '@/Components/TextArea.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import { useConfirm } from '/resources/js/Utilities/Composables/useCofirm.js';
import { formatDistance, parseISO } from 'date-fns';
import axios from 'axios';
// import { isInProduction } from '@/Utilities/environment.js';


const form = useForm({
    title: '',
    body: '',
})

const createPost = () => {
    form.post(route('posts.store'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
    });
};

//import { comment } from "postcss";

const props = defineProps(['post', 'comments']);
const formattedData = computed(() => formatDistance(parseISO(props.post.created_at), new Date()));

const commentForm = useForm({
    body: '',
})

const commentTextAreaRef = ref(null);
const commentIdBeingEdited = ref(null);
const commentBeingEdited = computed(() => props.comments.data.find(comment => comment.id === commentIdBeingEdited.value));

const editComment = (commentId) => {
    commentIdBeingEdited.value = commentId;
    commentForm.body = commentBeingEdited.value?.body;
    commentTextAreaRef.value?.focus();
};

const cancelEditComment = () => {
    commentIdBeingEdited.value = null;
    commentForm.reset();
};

const addComment = () => commentForm.post(route('posts.comments.store', props.post.id), {
    preserveScroll: true,
    preserveState: (page) => Object.keys(page.props.errors).length > 0,
    onSuccess: () => {
        commentForm.reset();
        // Force reload just the comments
        router.reload({ only: ['comments'] });
    },
});

const { confirmation } = useConfirm();

const updateComment = async () => {

    if (! await confirmation('Are you sure you want to update this comment?')) {

        commentTextAreaRef.value?.focus();
        return;
    }

    commentForm.put(route('comments.update', {
        comment: commentIdBeingEdited.value,
        page: props.comments.current_page,
    }), {
        preserveScroll: true,
        onSuccess: () => {
            commentIdBeingEdited.value = null;
            commentForm.reset();
            cancelEditComment()
        },
    });
};

const deleteComment = async (commentId) => {
    if (! await confirmation('Are you sure you want to delete this comment?')) {
    return;
    }

    router.delete(route('comments.destroy', { comment: commentId, page: props.comments.current_page }), {
        preserveScroll: true,
    });
};

// const isInProduction = () => import.meta.env.PROD;


const autofill = async () => {
   //if (isInProduction()) {
   //    return;
 //}
    const response = await axios.get('/local/post-content');
    form.title = response.data.title;
    form.body = response.data.body;
}
</script>