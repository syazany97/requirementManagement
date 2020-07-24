<template>
    <div>
        <!--        <button @click="addNode">Add New Module</button>-->
        <vue-tree-list
            @click="onClick"
            @change-name="onChangeName"
            @delete-node="onDel"
            @add-node="onAddNode"
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

    export default {
        name: "RequirementList",
        components: {CreateNewModule},
        props: {
            modules: Array
        },
        created() {
            this.setModules();
        },
        data() {
            return {
                data: [],
                newTree: {},
                loaded: false
            }
        },
        computed : {
          requirementList () {
              // vue tree list wont change if we use the computed property for this data
              // so we need to listen for changes and then retrieve the new requirement list if it
              // changes. The only way is to set a computed property and listen for changes
              return this.$store.getters['requirementList/requirementList'];
          }
        },
        watch : {
          requirementList() {
              this.setModules();
          }
        },
        methods: {
            setModules() {
               this.data =  new Tree(replaceKeysDeep(
                    JSON.parse(JSON.stringify(this.$store.getters['requirementList/requirementList'])), {
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
                console.log(params)
            },

            onClick(params) {
                if (params.type === 'requirement') {
                    this.$store.commit('requirementList/setRequirement', params);
                }
                console.log(params)
            },

            addNode() {
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
            }
        }
    }
</script>

