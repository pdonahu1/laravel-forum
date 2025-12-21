<template>
<AppLayout>
    <Container>
        <ul class="divide-y">
            <li v-for="post in posts.data" :key="post.id" class="py-4 px-2">
                <span class="font-bold text-lg">{{ post.title }}</span>
            </li>
        </ul>
        <Pagination :meta="posts" :only="['posts']" />
    </Container>
</AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Container from '@/Components/Container.vue';
import Pagination from '@/Components/Pagination.vue';
import { onMounted } from 'vue';

const props = defineProps({
    posts: Object,
});

onMounted(() => {
    console.log('Posts prop:', props.posts);
});
</script>