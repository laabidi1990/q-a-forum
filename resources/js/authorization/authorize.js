
import policies from './policies';

export default {
    install(Vue, options) {
        Vue.prototype.authorize = function(policy, model) {
            if (!window.auth.signedIn) 
                return false;

            else if (typeof policy === 'string' && typeof model === 'object') {
                const user = window.auth.user;
                return policies[policy](user, model);
            };
        }

        Vue.prototype.signedIn = window.auth.signedIn;
    }
}

