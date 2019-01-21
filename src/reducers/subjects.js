import {createReducer} from './utils';
import * as actionTypes from '../actions';

const initialState =  {
    all: [],
    isLoaded: false
}

export const subjects = createReducer(initialState, {
    [actionTypes.RECEIVE_SUBJECTS]: (state, { subjects }) => {
        return {...state, all: subjects, isLoaded: true};
    }
});
