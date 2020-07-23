<template>
    <v-card
        v-if="requirement.id !== null"
        class="pa-2"
        outlined
        tile
    >
        <h6>{{requirement.numbering}} {{requirement.name}}</h6>

        <v-row>
            <v-col cols="6" md="6">
                <v-list-item v-for="(value, propertyName) in firstList" v-bind:key="propertyName" two-line>
                    <v-list-item-content>
                        <v-list-item-title>{{propertyName | titleCase}}</v-list-item-title>
                        <v-list-item-subtitle>{{value}}</v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>
            </v-col>

            <v-col cols="6" md="6">
                <v-list-item v-for="(value, propertyName) in secondList" v-bind:key="propertyName" two-line>
                    <v-list-item-content>
                        <v-list-item-title>{{propertyName | titleCase}}</v-list-item-title>
                        <v-list-item-subtitle>{{value}}</v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>
            </v-col>
        </v-row>

        <h5>Description</h5>
        <span>{{requirement.description}}</span>

        <h5>Attachments</h5>
        <v-btn x-small>
            <v-icon left dark>mdi-upload</v-icon>
            Upload a file
        </v-btn>

        <h5>Comments</h5>
        <div v-if="comments.length">
            <v-list-item v-for="comment in comments" v-bind:key="comment.id">
                <v-list-item-content>
                    <v-list-item-title>{{comment.user.name}} {{comment.created_at | formatDateTime}}</v-list-item-title>
                    <span>{{comment.details}}</span>
                </v-list-item-content>
                <v-btn @click="deleteComment(comment.id)" x-small danger v-if="comment.meta.allowed_to_delete">Delete</v-btn>
            </v-list-item>
        </div>

        <v-btn v-show="!showCommentTextField" x-small text @click="showCommentTextField = true">Add comment</v-btn>
        <div v-if="showCommentTextField">
        <v-textarea
            v-model="comment"
            solo
            name="input-7-4"
            label="Solo textarea"
        ></v-textarea>
        <v-btn small @click="postComment">Post</v-btn>
        </div>

    </v-card>
</template>

<script>
    import requirementCommentRepository from "../../repositories/requirementCommentRepository";
    import dayjs from "dayjs";

    export default {
        name: "ShowRequirement",
        data() {
            return {
                itemsColumn: ['email', 'assigned'],
                comments: [],
                comment: "",
                showCommentTextField : false
            }
        },
        computed: {
            requirement() {
                return this.$store.getters['requirementList/currentRequirement']
            },
            firstList() {
                return {
                    assigned: this.get(this.requirement, 'assigned.name', ''),
                    created: dayjs(this.requirement.created_at).format('LLL'),
                    updated: dayjs(this.requirement.updated_at).format('LLL')
                }
            },
            secondList() {
                return {
                    priority: this.get(this.requirement, 'priority.title', ''),
                    type: this.requirement.type
                }
            }
        },
        watch: {
            requirement() {
                this.showCommentTextField = false;
                if (this.requirement.id !== null) {
                    this.fetchComments();
                }
            }
        },
        methods: {
            get(data, column, defaultValue) {
                return _.get(data, column, defaultValue);
            },
            async fetchComments() {
                const response = await requirementCommentRepository.all(this.requirement.id);
                this.comments = response.data.data;
            },
            async postComment() {
                try {
                    const response = await requirementCommentRepository.store(this.requirement.id, {details : this.comment});
                    this.comment = "";
                    await this.fetchComments();
                } catch (e) {
                    console.log(e);
                }
            },
            async deleteComment(commentId) {
                try {
                    const response = await requirementCommentRepository.delete(commentId);
                    this.comment = "";
                    await this.fetchComments();
                } catch (e) {
                    console.log(e);
                }

            }
        }
    }
</script>

<style scoped>

</style>
