## PHP Assignment

The aim of this project is to show BDD process and gain the experience with symfony components

To start php assignment please follow the next steps:
*  [Fork this repo](#user-content-how-to-fork-this-repo)
*  [Setup the work environment](#user-content-how-to-setup-work-environment)
*  [Implement assignment using BDD fashion](#user-content-implement-assignment-using-bdd-fashion)

### How to fork this repo
* Click the **Fork** button at the top-right corner of this page and the repository will be copied to your own account.
* Run `git clone https://github.com/<your-account>/php-assignment.git` from command line to download the repo.

### How to setup work environment
* Install `docker` and `docker-compose`, (https://docs.docker.com/)
* Run `docker-compose up`
* Access in your favorite browser http://localhost:8000

Note: Current version of `docker-compose.yml` contain a single service (php) witch have `composer` and `xdebug` installed,
 the service is designed to work on port 8000 and is working with built in server from php



### Implement assignment using BDD fashion
Now you are ready to implement assignment. Tasks are located in the **task** folder. Each module consists of several tasks for specified topic. Each task is usually a regular function:
```javascript
  /**
   * Returns the result of concatenation of two strings.
   *
   * @param {string} value1
   * @param {string} value2
   * @return {string}
   *
   * @example
   *   'aa', 'bb' => 'aabb'
   *   'aa',''    => 'aa'
   *   '',  'bb'  => 'bb'
   */
  function concatenateStrings(value1, value2) {
     throw new Error('Not implemented');
  }
```
Resolve this task using the following [TDD steps](https://en.wikipedia.org/wiki/Test-driven_development#Test-driven_development_cycle):
* Run unit tests and make sure that everything is OK and there are no failing tests.
* Read the task description in the comment above the function. Try to understand the idea. If you got it you are to write unit test first, but unit tests are already prepared :) Skip step with writing unit tests.
* Remove the throwing error line from function body
```javascript
     throw new Error('Not implemented');
```
and run the unit tests again. Find one test failed (red). Now it's time to fix it!
* Implement the function by any way and verify your solution by running tests until the failed test become passed (green).
* Your solution work, but now time to refactor it. Try to make your code as pretty and simple as possible keeping up the test green.
* Once you can't improve your code and tests are passed you can commit your solution.
* Push your updates to github server and check if tests passed on [travis-ci](https://travis-ci.org/rolling-scopes-school/js-assignments/builds).
* If everything is OK you can try to resolve the next task.

### How to debug tasks
To debug tests you can use **Node inspector**. To install it just run `npm install -g node-inspector` in your terminal. Then follow next steps:
* Add `debugger;` to the first line of your task.
* Run your test file with `npm run test-debug ./test/01-strings-tests.js`.
* In another terminal run `node-inspector` and copy link from the output.
* Open the link in your favorite browser. You should see Chrome Developers Tools like interface where you can debug your tasks.
* When you found and fix your issue, close the browser's tab with the debug tools, stop the node-inspector by pressing Ctrl-C, stop the test runner by pressing Ctrl-C, remove the `debugger;` from your task.

##Contribution
Feel free to contribute into this project. New tasks and katas are welcome.

