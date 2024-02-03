// Define baseURL
//axios.defaults.baseURL = 'http://localhost:8000'
axios.defaults.baseURL = "http://mailer-test.test";

// Declare component
const ViewSubscriber = {
    template: "#view-subscriber",

    // Guard beforeRouteEnter() always called before route access
    // lets reset subcsriber data
    beforeRouteEnter(to, from, next) {
        next((vm) => {
            vm.$root.subscriber = {
                email: "",
                firstname: "",
                lastname: "",
                status: "",
            };
        });
    },
};
// - Route: Add
const AddSubscriber = {
    template: "#add-subscriber",

    beforeRouteEnter(to, from, next) {
        next((vm) => {
            vm.$root.message = "";
        });
    },
};
// - Route: Edit
const EditSubscriber = {
    template: "#edit-subscriber",
    
    // We use this to get Subscriber when route is accessed
    // so data can be filled based on provided id
    beforeRouteEnter(to, from, next) {
        next((vm) => {
            vm.$root.getSubscriber(to.params.id_subscriber);
            vm.$root.message = "";
        });
    },
};

// Register component
Vue.component('pagination', Pagination);

// Start Vue App
const app = new Vue({
    el: "#app",
    components: {
        Pagination
    },
    data : {
        subscribers: [],
        subscriber: { email: "", firstname: "", lastname: "", status: "" },
        message: "",
        page: 1,
        perPage: 10,
        pages: [],
        records: [],
        recordsLength: 0
    },

    // Routing
    router: new VueRouter({
        routes: [
            { path: "/", component: ViewSubscriber, name: "view-subscriber" },
            {
                path: "/subscriber/add",
                component: AddSubscriber,
                name: "add-subscriber",
            },
            {
                path: "/subscriber/:id_subscriber/edit",
                component: EditSubscriber,
                name: "edit-subscriber",
            },
        ],
    }),

    // Methods
    methods: {
        getAllSubscriber() {
            axios.get("/api.php").then((response) => {
                this.subscribers = response.data;
                this.recordsLength = this.subscribers.length;
            });
        },

        getSubscriber(sid) {
            this.subscriber = this.subscribers.find(function (item) {
                return item.id == sid;
            });
        },

        addSubscriber() {
            axios.post("/api.php", this.subscriber).then((response) => {
                this.message = response.data.message;

                this.subscribers.push(this.subscriber);

                this.$router.push({ name: "view-subscriber" });
            });
        },

        editSubscriber(sid) {
            axios.patch("/api.php?id=" + sid, this.subscriber).then((response) => {
                this.message = response.data.message;

                // Get index from Subscriber with provided id to be use in splice()
                var i = this.subscribers.findIndex(function (item) {
                    return item.id == sid;
                });
                // Replace old data with new one. 
                this.subscribers.splice(i, 1, this.subscriber);

                this.$router.push({ name: "view-subscriber" });
            });
        },

        deleteSubscriber(sid) {
            if (confirm("Remove this data?")) {
                axios.delete("/api.php?id=" + sid).then((response) => {
                    this.message = response.data.message;

                    // Get index from Subscriber with provided id to be use in splice()
                    var i = this.subscribers.findIndex(function (item) {
                        return item.id == sid;
                    });
                    // Remove selected data.
                    this.subscribers.splice(i, 1);
                });
            }
        },

        getPage() {
            // we simulate an api call that fetch the records from a backend
            this.records = [];
            const startIndex = this.perPage * (this.page - 1) + 1;
            const endIndex = startIndex + this.perPage - 1;
            for (let i = startIndex; i <= endIndex; i++) {
                this.records.push(`Item ${i}`);
            }
        },
        getRecordsLength() {
            // here we simulate an api call that returns the records length
            this.recordsLength = this.records.length;
        }
    },

    computed: {
        displayedSubs: function () {
            const startIndex = this.perPage * (this.page - 1);
            const endIndex = startIndex + this.perPage;
            return this.subscribers.slice(startIndex, endIndex);
        }
    },

    // getAllSubscriber() 1st time
    created() {
        this.getAllSubscriber();        
    }
});
