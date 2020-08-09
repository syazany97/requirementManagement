<template>
    <div>
        <div v-if="!commentsLoaded" class="text-center">
            <v-progress-circular
                :width="2"
                size="15"
                color="blue"
                indeterminate
            ></v-progress-circular>
        </div>
        <div v-if="comments.length && commentsLoaded">
            <div v-for="comment in comments" v-bind:key="comment.id">
                <div class="flex justify-between mb-1">
                    <p class="text-grey-darkest leading-normal text-lg">{{ comment.details }}</p>
                    <button v-if="comment.meta.permissions.delete"
                            class="text-red hover:bg-red hover:text-white
                            py-2 px-4 rounded tracking-wide mb-2 md:mb-0
                            md:ml-auto" @click="deleteComment(comment.id)">Delete
                    </button>
                </div>
                <div class="text-grey leading-normal text-sm">
                    <p>{{ get(comment, 'user.name', '') }} <span class="mx-1 text-xs">&bull;</span> {{
                            comment.created_at |
                                formatDateTime
                        }}</p>
                </div>
            </div>
        </div>
        <span v-if="!comments.length && commentsLoaded">No comment yet for this requirement</span>
        <v-btn v-show="!showCommentTextField" x-small text @click="showCommentTextField = true">Add comment</v-btn>
        <div v-if="showCommentTextField">
             <textarea v-model="comment"
                       placeholder="Add comment"
                       class="bg-grey-dark rounded leading-normal resize-none w-full h-24 py-2 px-3">
            </textarea>
            <div class="text-right">
                <v-btn small @click="postComment">Post</v-btn>
            </div>
        </div>
    </div>
</template>
<script>
import requirementCommentRepository from "../../../repositories/requirementCommentRepository";
import commentRepository from "../../../repositories/comment/commentRepository";
import testCaseCommentRepository from "../../../repositories/testCase/comment/testCaseCommentRepository";

export default {
    name: 'comment-list',
    props: {
        requirement: Object,
        // determine which repository to retrieve the comments
        repositoryType: {
            type: String,
            default: 'requirement'
        },
        testCase : Object
    },
    data() {
        return {
            comment: "",
            comments: [],
            commentsLoaded: false,
            showCommentTextField: false,
            repository : null,
            params : {}
        }
    },
    watch: {
        requirement() {
            this.commentsLoaded = false;
            this.showCommentTextField = false;

            if (this.requirement.id !== null) {
                this.fetchComments();
            }
        }
    },
    created() {
        this.fetchComments();
    },
    methods: {
        async postComment() {
            try {
                await this.repository.store(this.params.id, {details: this.comment});
                this.comment = "";
                await this.fetchComments();
            } catch (e) {
                console.log(e);
            }
        },
        async deleteComment(commentId) {
            try {
                await commentRepository.delete(commentId);
                this.comment = "";
                await this.fetchComments();
            } catch (e) {
                console.log(e);
            }
        },
        async fetchComments() {

            if (this.repositoryType === 'requirement') {
                this.repository = requirementCommentRepository;
                this.params = this.requirement;
            } else if (this.repositoryType === 'test-case') {
                this.repository = testCaseCommentRepository;
                this.params = this.testCase;
            }

            const response = await this.repository.all(this.params.id);
            this.comments = response.data.data;
            this.commentsLoaded = true;
        },
        get(data,  parameters, defaultValue) {
            return _.get(data,  parameters, defaultValue);
        }
    }

}
</script>
