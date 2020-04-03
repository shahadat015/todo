<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Todo List</title>
    <link rel="stylesheet" href="css/app.css">
</head>
<body>
    <section id="app">
        <div class="container">
            <div class="row justify-content-md-center">
                <div class="col-sm-12 col-md-6">
                    <h1 class="text-center title">todos</h1>
                    <div class="card">
                        <div class="card-header border-light">
                            <form method="post" @submit.prevent="submit">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-chevron-down"></i></div>
                                    </div>
                                    <input type="text" v-model="task" class="form-control" placeholder="What needs to be done?">
                                </div>
                            </form>
                        </div>
                        <div class="card-body" v-if="todos.length > 0">
                            <tasks v-for="todo in todos" :todo="todo" @done="taskCompleted" :key="todo.id" ></tasks>
                            <div class="border-light card-footer">
                                <div class="row">
                                    <div class="col-md-3">
                                        <span>{{ incomplete.length }} items left</span>
                                    </div>
                                    <div class="col-md-5">
                                        <a href="javascript:void(0)" @click="tasks">All</a>
                                        <a href="javascript:void(0)" @click="activeTasks">Active</a>
                                        <a href="javascript:void(0)" @click="completeTasks">Completed</a>
                                    </div>
                                    <div class="col-md-4 text-right">
                                        <a href="javascript:void(0)" @click="remove">Clear Completed</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="js/app.js"></script>
</body>
</html>