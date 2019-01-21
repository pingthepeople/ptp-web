import {createReducer} from './utils';
import * as actionTypes from '../actions';

const initialState =  {
    all: [],
    isLoaded: false
}

export const bills = createReducer(initialState, {
    [actionTypes.RECEIVE_BILLS]: (state, { bills }) => {
        return {...state, all: bills, isLoaded: true};
    }
});
