This project was bootstrapped with [Create React App](https://github.com/facebook/create-react-app).

## Available Scripts

In the project directory, you can run:

### `npm start`

Runs the app (in the development mode) and the json-server.<br>
Open [http://localhost:3000](http://localhost:3000) to view it in the browser. Open [http://localhost:3001](http://localhost:3001) to view API responses.

### `npm test`

Launches the test runner in the interactive watch mode.<br>
See the section about [running tests](https://facebook.github.io/create-react-app/docs/running-tests) for more information.

### `npm run build`

Builds the app for production to the `build` folder.<br>

See the section about [deployment](https://facebook.github.io/create-react-app/docs/deployment) for more information.

### `npm run start-server`

Runs a mock server to deliver API responses. Open [http://localhost:3001](http://localhost:3001) to view API responses.

The React app relies on an API server to provide the bills, legislators, and other data. To make local development easier, the API server is mocked using [json-server](https://github.com/typicode/json-server) and [faker](https://github.com/Marak/faker.js). See [db.js](db.js) for the code that generates the server responses.

Install json-server globally, per the the [json-server documentation](https://github.com/typicode/json-server#getting-started), then run `npm run start-server` in the project directory to start the server.

### `npm run start-client`

Runs the React app without running the mock server. Open [http://localhost:3000](http://localhost:3000) to view it in the browser.