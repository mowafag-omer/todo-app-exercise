var app = new Vue({
  el: document.getElementById('App'),
  data: {
    tasks: [],
    completed: [],
    newtask: null,
  },
  methods: {
    getTasks: function () {
      fetch('http://localhost/todo-app/app/getTasks')
        .then(response => response.json())
        .then(data => {
          this.tasks = data.filter(task => task.is_done == "0")
          this.completed = data.filter(task => task.is_done == "1")
        })
    },
    addTask: function (e) {
      e.preventDefault()
      fetch('http://localhost/todo-app/app/addTask', {
        method: 'POST', 
        mode: 'cors',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({task: this.newtask})
      })
        .then(_ => {
          this.getTasks()
          this.newtask = null
        })
    },
    toggle: function (task) {
      var done = parseInt(task.is_done) ? 0 : 1
      console.log(done);
      fetch(`http://localhost/todo-app/app/toggle.php?id=${task.id}`, {
        method: 'POST', 
        mode: 'cors',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({done: done})
      })
        .then(_ => this.getTasks())
    }
  },
  created: function () {
    this.getTasks()
  }
})