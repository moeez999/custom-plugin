# Teacher Color Indicator Feature

## Overview
This feature adds visual color indicators for teachers in both the dropdown pills and calendar events. Each teacher is assigned a unique color based on their ID, which is displayed as a colored border around their avatar in the dropdown and as a colored dot in the bottom-right corner of their related calendar events.

## Implementation Details

### 1. CSS Changes (`calendar_admin_details.css`)

#### Added Teacher Color Palette
```css
--teacher-color-1: #7c96ff;   /* Blue */
--teacher-color-2: #ff6b6b;   /* Red */
--teacher-color-3: #2faa7f;   /* Green */
--teacher-color-4: #a855f7;   /* Purple */
--teacher-color-5: #f59e0b;   /* Amber */
--teacher-color-6: #ec4899;   /* Pink */
--teacher-color-7: #06b6d4;   /* Cyan */
--teacher-color-8: #8b5cf6;   /* Violet */
--teacher-color-9: #10b981;   /* Emerald */
--teacher-color-10: #f97316;  /* Orange */
```

#### Teacher Avatar Styling
Updated `.teacher-summary-avatar` styles to support colored box-shadow borders based on `data-teacher-color` attribute:
- Each color (1-10) has a corresponding CSS rule with `box-shadow: 0 0 0 3px var(--teacher-color-X)`
- Creates a 3px colored border effect around teacher avatars in the dropdown

### 2. CSS Changes (`calendar_admin_details_calendar_content.css`)

#### Event Indicator Dot Styles
```css
.event::after {
  content: "";
  position: absolute;
  bottom: 4px;
  right: 4px;
  width: 10px;
  height: 10px;
  border-radius: 50%;
  background-color: #ccc;
  opacity: 0;
  transition: opacity 0.2s ease;
}

.event.has-teacher-indicator::after {
  opacity: 1;
}
```

#### Teacher Color Classes for Events
```css
.event.teacher-1::after { background-color: var(--teacher-color-1); }
.event.teacher-2::after { background-color: var(--teacher-color-2); }
... (colors 3-10)
```

### 3. JavaScript Changes (`calendar_admin_details_calendar_content.js`)

#### Helper Function
```javascript
function getTeacherColorIndex(teacherId) {
  if (!teacherId) return 1;
  return ((Math.abs(teacherId) % 10) || 10);
}
```
- Consistently maps teacher IDs to color indices 1-10 using modulo arithmetic
- Ensures the same teacher always gets the same color

#### Teacher Pills Update
Modified `updateTeacherPills()` function to add `data-teacher-color` attribute to avatar images:
```javascript
const colorIndex = getTeacherColorIndex(id);
img.dataset.teacherColor = colorIndex;
```

#### Event Rendering
Updated event creation in `renderWeek()` to:
1. Calculate teacher color index from `ev.teacherId`
2. Add teacher color class (e.g., `teacher-1`, `teacher-2`)
3. Add `has-teacher-indicator` class to show the dot
4. Store teacher ID in `data-teacher-id` attribute

#### Event Data Mapping
Updated `fetchCalendarEvents()` to include `teacherId` from API response:
```javascript
teacherId: ev.teacher_id || null,
```

## How It Works

### Desktop View (Dropdown Pills)
1. When teachers are selected, their avatars appear in the dropdown pill container
2. Each avatar displays a colored border matching their assigned color
3. The color is determined by the teacher ID using the `getTeacherColorIndex()` function

### Calendar View
1. Events fetched from the API include `teacher_id` field
2. Each event gets a colored indicator dot (10px circle) in the bottom-right corner
3. The dot color matches the teacher's assigned color
4. The dot only shows if an event has a teacher ID (`has-teacher-indicator` class)

## Color Distribution
Teachers are assigned colors based on their ID using modulo 10:
- Teacher ID 1 → Color 1 (Blue #7c96ff)
- Teacher ID 2 → Color 2 (Red #ff6b6b)
- Teacher ID 11 → Color 1 (Blue #7c96ff)
- Teacher ID 12 → Color 2 (Red #ff6b6b)
- And so on...

This ensures consistent color assignment and allows unlimited teachers while cycling through 10 distinct colors.

## API Requirements

The backend API (`calendar_admin_get_events.php`) should return events with the following structure:
```json
{
  "ok": true,
  "events": [
    {
      "teacher_id": 164,
      "title": "Lesson",
      "start": "2025-11-12T10:00:00",
      "end": "2025-11-12T11:00:00",
      "class_type": "weekly",
      "is_recurring": false,
      "meetingurl": "...",
      ...
    }
  ]
}
```

## Browser Compatibility
- Modern browsers supporting CSS custom properties (CSS variables)
- CSS box-shadow for border effect
- CSS ::after pseudo-element for indicator dot
- JavaScript ES6+ features

## Visual Result
- **Teacher Avatars**: Colorful 3px borders around each teacher's avatar in the dropdown
- **Calendar Events**: Small colored dots (10px) in the bottom-right corner of events
- **Consistency**: Same teacher always shows the same color across the UI
