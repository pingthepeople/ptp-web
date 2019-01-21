import {createReducer} from './utils';
import * as actionTypes from '../actions';

const initialState =  {
    all: [],
    isLoaded: false
}

export const legislators = createReducer(initialState, {
    [actionTypes.RECEIVE_LEGISLATORS]: (state, { legislators }) => {
        return {...state, all: legislators, isLoaded: true};
    }
});
