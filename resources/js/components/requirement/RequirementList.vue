<template>
    <div>
        <!--        <button @click="addNode">Add New Module</button>-->
        <vue-tree-list
            @click="onClick"
            @change-name="onChangeName"
            @delete-node="onDel"
            @add-node="onAddNode"
            @drop="onDrop"
            @drop-before="onDropBefore"
            @drop-after="onDropAfter"
            :model="data"
            default-tree-node-name="new module"
            default-leaf-node-name="new requirement"
            v-bind:default-expanded="false"
        >
            <template v-slot:leafNameDisplay="slotProps">
        <span>
          {{slotProps.model.numbering}} {{ slotProps.model.name }}
        </span>
            </template>
            <span class="icon" slot="addTreeNodeIcon">📂</span>
            <span class="icon" slot="addLeafNodeIcon">＋</span>
            <span class="icon" slot="editNodeIcon">📃</span>
            <span class="icon" slot="delNodeIcon">✂</span>
            <span class="icon" slot="leafNodeIcon">🍃</span>
            <span class="icon" slot="treeNodeIcon">📂</span>
        </vue-tree-list>


        <pre>
      {{newTree}}
    </pre>

    </div>
</template>

<script>
    import {VueTreeList, Tree, TreeNode} from 'vue-tree-list';
    import CreateNewModule from "../modules/dialog/CreateNewModule";
    import moduleRepository from "../../repositories/moduleRepository";

    export default {
        name: "RequirementList",
        components: {CreateNewModule},
        created() {
            this.setModules();
        },
        data() {
            return {
                data: [],
                newTree: {},
                loaded: false,
                projectId: this.$route.params.project
            }
        },
        computed: {
            requirementList() {
                // vue tree list wont change if we use the computed property for this data
                // so we need to listen for changes and then retrieve the new requirement list
                // if it changes
                return this.$store.getters['requirement/requirementList'];
            }
        },
        watch: {
            requirementList() {
                this.setModules();
            }
        },
        methods: {
            setModules() {
                this.data = new Tree(replaceKeysDeep(
                    JSON.parse(JSON.stringify(this.$store.getters['requirement/requirementList'])), {
                        requirements: 'children'
                    }))

                function replaceKeysDeep(obj, keysMap) { // keysMap = { oldKey1: newKey1, oldKey2: newKey2, etc...
                    return _.transform(obj, function (result, value, key) { // transform to a new object

                        if (result.type === 'requirement') result.isLeaf = true;

                        let currentKey = keysMap[key] || key; // if the key is in keysMap use the replacement, if not use the original key

                        result[currentKey] = _.isObject(value) ? replaceKeysDeep(value, keysMap) : value; // if the key is an object run it through the inner function - replaceKeys
                    });
                }

            },

            onDel(node) {
                console.log(node)
                node.remove()
            },

            onChangeName(params) {
                console.log(params)
            },

            onAddNode(params) {
                console.log('on add node');
                console.log(params)
            },

            onClick(params) {
                if (params.type === 'requirement') {
                    console.log(this.$route);
                    history.replaceState(
                        {requirement : params.id},
                        null,
                        '?requirement=' + params.id
                    )
                    this.$store.commit('requirement/setRequirement', params);
                }
            },

            addNode() {
                console.log('add node');
                var node = new TreeNode({name: 'new node', isLeaf: false})
                if (!this.data.children) this.data.children = []
                this.data.addChildren(node)
            },

            getNewTree() {
                var vm = this

                function _dfs(oldNode) {
                    var newNode = {}

                    for (var k in oldNode) {
                        if (k !== 'children' && k !== 'parent') {
                            newNode[k] = oldNode[k]
                        }
                    }

                    if (oldNode.children && oldNode.children.length > 0) {
                        newNode.children = []
                        for (var i = 0, len = oldNode.children.length; i < len; i++) {
                            newNode.children.push(_dfs(oldNode.children[i]))
                        }
                    }
                    return newNode
                }

                vm.newTree = _dfs(vm.data)
            },

            onDrop(params) {
                // if the target and source node are the same, dont update the data
                // since the node doesnt change its position
                if (params.node.id !== params.target.id) {
                    console.log('VALID ON DROP');
                    let payload = {
                        id: params.node.id,
                        name: params.node.name,
                        parent_id: params.target.id
                    }
                    this.updateModuleAfterDrop(payload);
                }
                console.log('ON DROP', params);
            },

            onDropAfter(params) {
                // this.updateModuleAfterDrop(params);
                console.log('ON DROP AFTER', params);
            },

            onDropBefore(params) {
                // if node is placed as top level node then set parent id to null
                // otherwise, use the parent id node
                let parent_id = params.target.parent_id !== null ? params.target.parent_id : null;

                this.updateModuleAfterDrop({
                    id: params.node.id,
                    name: params.node.name,
                    parent_id: parent_id
                });
                console.log('ON DROP BEFORE', params);
            },


            async updateModuleAfterDrop(payload) {

                try {
                    await moduleRepository.update(payload.id, payload)

                    this.$store.dispatch('requirement/setRequirementList', {project_id: this.projectId});

                } catch (e) {
                    console.log(e);
                }


            }
        }
    }
</script>

