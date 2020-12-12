<template>
    <div>

        <v-list-item v-for="attachment in attachments" v-bind:key="attachment.id">
            <v-list-item-content>
                <v-list-item-title>
                    <v-btn :href="attachment.attachment_url" target="_blank" text>{{attachment.name}}</v-btn>
                </v-list-item-title>
            </v-list-item-content>
        </v-list-item>
        <v-btn @click="$refs.uploadRequirementAttachment.$el.click()" x-small>
            <v-icon left dark>mdi-upload</v-icon>
            Upload a file
        </v-btn>
        <v-file-input ref="uploadRequirementAttachment" v-model="fileAttachment"
                      label="Upload a file"></v-file-input>
    </div>
</template>
<script>
    import requirementAttachmentRepository from "../../../repositories/requirementAttachmentRepository";

    export default {
        name: 'attachment-list',
        props: {
            requirement : Object
        },
        data() {
          return {
              fileAttachment : null,
              attachments : []
          }
        },
        created() {
            // if url contains query parameter requirement then set data
            if (this.requirement.id !== null) {
                this.fetchAttachments();
            }
        },
        watch : {
            requirement() {
                if (this.requirement.id !== null) {
                    this.fetchAttachments();
                }
            },
            fileAttachment() {
                if (this.fileAttachment !== null) {
                    this.uploadFile();
                }
            }
        },
        methods: {
            async uploadFile() {
                try {
                    let formData = new FormData;
                    formData.append('file', this.fileAttachment);
                    await requirementAttachmentRepository.store(this.requirement.id, formData);
                    this.fileAttachment = null;
                    await this.fetchAttachments();
                } catch (e) {
                    console.log(e);
                }
            },
            async fetchAttachments() {
                const response = await requirementAttachmentRepository.all(this.requirement.id);
                this.attachments = response.data.data;
            }
        }
    }
</script>
