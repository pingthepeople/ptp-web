import React from 'react';
import { render } from 'react-dom';
import App from './App';
import * as serviceWorker from './serviceWorker';
import { createStore, applyMiddleware } from 'redux';
import { Provider } from 'react-redux';
import thunk from 'redux-thunk'
import { createLogger } from 'redux-logger'
import rootReducer from './reducers';
import { 
    fetchBills, 
    fetchLegislators,
    fetchSubjects,
    fetchCommittees,
} from './actions';

const middleware = [ thunk ]
if (process.env.NODE_ENV !== 'production') {
  middleware.push(createLogger())
}

const store = createStore(
    rootReducer,
    applyMiddleware(...middleware)
);

store.dispatch(fetchBills());
store.dispatch(fetchLegislators());
store.dispatch(fetchSubjects());
store.dispatch(fetchCommittees());

render(
    <Provider store={store}>
        <App />
    </Provider>, 
    document.getElementById('root')
);

// If you want your app to work offline and load faster, you can change
// unregister() to register() below. Note this comes with some pitfalls.
// Learn more about service workers: http://bit.ly/CRA-PWA
serviceWorker.unregister();
