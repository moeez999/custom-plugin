/**
 * One2One Form State Manager
 * React-like state management for 1:1 event forms
 * 
 * Features:
 * - Original state tracking (for reset)
 * - Current state tracking (form values)
 * - Dirty state detection
 * - Change tracking
 * - Reset functionality
 */

(function (global) {
  "use strict";

  /**
   * Form State Manager Class
   * Manages form state similar to React's useState pattern
   */
  class One2OneFormStateManager {
    constructor(formId) {
      this.formId = formId;
      this.originalState = null;
      this.currentState = null;
      this.isDirty = false;
      this.listeners = [];
      this.changeHistory = [];
    }

    /**
     * Initialize state with original data
     * @param {Object} originalData - Original event data
     */
    initialize(originalData) {
      if (!originalData) {
        console.warn('[One2OneFormStateManager] No original data provided');
        return;
      }

      // Deep clone to prevent reference issues
      this.originalState = this.deepClone(originalData);
      this.currentState = this.deepClone(originalData);
      this.isDirty = false;
      this.changeHistory = [];

      this.notifyListeners('initialized', {
        original: this.originalState,
        current: this.currentState
      });

      console.log('[One2OneFormStateManager] State initialized', {
        original: this.originalState,
        current: this.currentState
      });
    }

    /**
     * Update current state
     * @param {Object|Function} updates - Object with updates or function that returns updates
     */
    setState(updates) {
      const prevState = this.deepClone(this.currentState);

      if (typeof updates === 'function') {
        this.currentState = updates(this.currentState);
      } else {
        this.currentState = this.mergeDeep(this.currentState, updates);
      }

      // Check if state is dirty
      this.isDirty = !this.isEqual(this.originalState, this.currentState);

      // Track changes
      const changes = this.detectChanges(prevState, this.currentState);
      if (changes.length > 0) {
        this.changeHistory.push({
          timestamp: Date.now(),
          changes: changes
        });
      }

      this.notifyListeners('stateChanged', {
        previous: prevState,
        current: this.currentState,
        isDirty: this.isDirty,
        changes: changes
      });

      console.log('[One2OneFormStateManager] State updated', {
        previous: prevState,
        current: this.currentState,
        isDirty: this.isDirty,
        changes: changes
      });
    }

    /**
     * Get current state
     * @param {string} path - Optional path to specific property (e.g., 'teacher.id')
     * @returns {*} Current state or specific property
     */
    getState(path) {
      if (!path) {
        return this.deepClone(this.currentState);
      }

      return this.getNestedValue(this.currentState, path);
    }

    /**
     * Get original state
     * @param {string} path - Optional path to specific property
     * @returns {*} Original state or specific property
     */
    getOriginalState(path) {
      if (!path) {
        return this.deepClone(this.originalState);
      }

      return this.getNestedValue(this.originalState, path);
    }

    /**
     * Reset state to original
     */
    reset() {
      if (!this.originalState) {
        console.warn('[One2OneFormStateManager] No original state to reset to');
        return;
      }

      const prevState = this.deepClone(this.currentState);
      this.currentState = this.deepClone(this.originalState);
      this.isDirty = false;
      this.changeHistory = [];

      this.notifyListeners('reset', {
        previous: prevState,
        current: this.currentState
      });

      console.log('[One2OneFormStateManager] State reset', {
        previous: prevState,
        current: this.currentState
      });
    }

    /**
     * Check if state is dirty (has unsaved changes)
     * @returns {boolean}
     */
    hasUnsavedChanges() {
      return this.isDirty;
    }

    /**
     * Get all changes since initialization
     * @returns {Array} Array of change objects
     */
    getChanges() {
      if (!this.originalState || !this.currentState) {
        return [];
      }

      return this.detectChanges(this.originalState, this.currentState);
    }

    /**
     * Get change history
     * @returns {Array} Array of change history entries
     */
    getChangeHistory() {
      return [...this.changeHistory];
    }

    /**
     * Commit current state as new original (after successful save)
     */
    commit() {
      if (!this.currentState) {
        console.warn('[One2OneFormStateManager] No current state to commit');
        return;
      }

      this.originalState = this.deepClone(this.currentState);
      this.isDirty = false;
      this.changeHistory = [];

      this.notifyListeners('committed', {
        original: this.originalState,
        current: this.currentState
      });

      console.log('[One2OneFormStateManager] State committed', {
        original: this.originalState,
        current: this.currentState
      });
    }

    /**
     * Subscribe to state changes
     * @param {Function} listener - Callback function
     * @returns {Function} Unsubscribe function
     */
    subscribe(listener) {
      if (typeof listener !== 'function') {
        throw new Error('Listener must be a function');
      }

      this.listeners.push(listener);

      // Return unsubscribe function
      return () => {
        const index = this.listeners.indexOf(listener);
        if (index > -1) {
          this.listeners.splice(index, 1);
        }
      };
    }

    /**
     * Notify all listeners
     * @private
     */
    notifyListeners(event, data) {
      this.listeners.forEach(listener => {
        try {
          listener(event, data);
        } catch (error) {
          console.error('[One2OneFormStateManager] Listener error', error);
        }
      });
    }

    /**
     * Detect changes between two states
     * @private
     */
    detectChanges(oldState, newState) {
      if (!oldState || !newState) {
        return [];
      }

      const changes = [];

      // Compare common fields
      const fieldsToCompare = [
        'teacherId',
        'studentId',
        'date',
        'start',
        'end',
        'duration',
        'lessonType',
        'status'
      ];

      fieldsToCompare.forEach(field => {
        const oldValue = oldState[field];
        const newValue = newState[field];

        if (!this.isEqual(oldValue, newValue)) {
          changes.push({
            field: field,
            oldValue: oldValue,
            newValue: newValue
          });
        }
      });

      // Compare nested objects
      if (oldState.singleLesson && newState.singleLesson) {
        const singleChanges = this.detectChanges(
          oldState.singleLesson,
          newState.singleLesson
        );
        changes.push(...singleChanges.map(c => ({
          ...c,
          field: `singleLesson.${c.field}`
        })));
      }

      if (oldState.weeklyLesson && newState.weeklyLesson) {
        const weeklyChanges = this.detectChanges(
          oldState.weeklyLesson,
          newState.weeklyLesson
        );
        changes.push(...weeklyChanges.map(c => ({
          ...c,
          field: `weeklyLesson.${c.field}`
        })));
      }

      return changes;
    }

    /**
     * Deep clone an object
     * @private
     */
    deepClone(obj) {
      if (obj === null || typeof obj !== 'object') {
        return obj;
      }

      if (obj instanceof Date) {
        return new Date(obj.getTime());
      }

      if (Array.isArray(obj)) {
        return obj.map(item => this.deepClone(item));
      }

      const cloned = {};
      for (const key in obj) {
        if (obj.hasOwnProperty(key)) {
          cloned[key] = this.deepClone(obj[key]);
        }
      }

      return cloned;
    }

    /**
     * Deep merge two objects
     * @private
     */
    mergeDeep(target, source) {
      const output = this.deepClone(target);

      if (this.isObject(target) && this.isObject(source)) {
        Object.keys(source).forEach(key => {
          if (this.isObject(source[key])) {
            if (!(key in target)) {
              output[key] = source[key];
            } else {
              output[key] = this.mergeDeep(target[key], source[key]);
            }
          } else {
            output[key] = source[key];
          }
        });
      }

      return output;
    }

    /**
     * Deep equality check
     * @private
     */
    isEqual(a, b) {
      if (a === b) return true;
      if (a == null || b == null) return false;
      if (typeof a !== typeof b) return false;

      if (Array.isArray(a) && Array.isArray(b)) {
        if (a.length !== b.length) return false;
        return a.every((item, index) => this.isEqual(item, b[index]));
      }

      if (this.isObject(a) && this.isObject(b)) {
        const keysA = Object.keys(a);
        const keysB = Object.keys(b);

        if (keysA.length !== keysB.length) return false;

        return keysA.every(key => this.isEqual(a[key], b[key]));
      }

      return false;
    }

    /**
     * Check if value is object
     * @private
     */
    isObject(value) {
      return value !== null && typeof value === 'object' && !Array.isArray(value);
    }

    /**
     * Get nested value by path
     * @private
     */
    getNestedValue(obj, path) {
      const keys = path.split('.');
      let value = obj;

      for (const key of keys) {
        if (value == null) return undefined;
        value = value[key];
      }

      return value;
    }
  }

  // Global instance manager
  const stateManagers = new Map();

  /**
   * Get or create state manager for a form
   * @param {string} formId - Form ID
   * @returns {One2OneFormStateManager}
   */
  function getStateManager(formId) {
    if (!stateManagers.has(formId)) {
      stateManagers.set(formId, new One2OneFormStateManager(formId));
    }

    return stateManagers.get(formId);
  }

  /**
   * Remove state manager
   * @param {string} formId - Form ID
   */
  function removeStateManager(formId) {
    stateManagers.delete(formId);
  }

  // Export
  global.One2OneFormStateManager = One2OneFormStateManager;
  global.getOne2OneStateManager = getStateManager;
  global.removeOne2OneStateManager = removeStateManager;

})(window);
