import { combineReducers } from 'redux'
import { bills } from './bills';
import { legislators } from './legislators';
import { subjects } from './subjects';
import { committees } from './committees';

export default combineReducers({
  bills,
  legislators,
  subjects,
  committees
});
