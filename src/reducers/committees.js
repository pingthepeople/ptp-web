import {createReducer} from './utils';
import * as actionTypes from '../actions';

const initialState =  {
    all: [],
    isLoaded: false
}

export const committees = createReducer(initialState, {
    [actionTypes.RECEIVE_COMMITTEES]: (state, { committees }) => {
        return {...state, all: committees, isLoaded: true};
    }
});
