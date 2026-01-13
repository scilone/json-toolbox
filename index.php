<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JSON Toolbox</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
        }

        .header p {
            font-size: 1.1em;
            opacity: 0.9;
        }

        .tabs {
            display: flex;
            background: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
        }

        .tab {
            flex: 1;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            background: #f8f9fa;
            border: none;
            font-size: 1.1em;
            font-weight: 600;
            color: #495057;
            transition: all 0.3s ease;
            position: relative;
        }

        .tab:hover {
            background: #e9ecef;
        }

        .tab.active {
            background: white;
            color: #667eea;
        }

        .tab.active::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            right: 0;
            height: 2px;
            background: #667eea;
        }

        .content {
            padding: 30px;
        }

        .tool-section {
            display: none;
        }

        .tool-section.active {
            display: block;
        }

        .input-section {
            margin-bottom: 30px;
        }

        .input-group {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
        }

        textarea {
            width: 100%;
            min-height: 150px;
            padding: 15px;
            border: 2px solid #dee2e6;
            border-radius: 8px;
            font-family: 'Courier New', monospace;
            font-size: 14px;
            resize: vertical;
        }

        textarea:focus {
            outline: none;
            border-color: #667eea;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            font-size: 1em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background: #5a6268;
        }

        .file-input {
            display: none;
        }

        .file-label {
            display: inline-block;
            padding: 12px 24px;
            background: #28a745;
            color: white;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .file-label:hover {
            background: #218838;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.4);
        }

        .output-section {
            margin-top: 30px;
        }

        .tree-view {
            background: #f8f9fa;
            border: 2px solid #dee2e6;
            border-radius: 8px;
            padding: 15px;
            max-height: 600px;
            overflow: auto;
            font-family: 'Courier New', monospace;
            font-size: 14px;
        }

        .tree-node {
            padding: 4px 0;
            cursor: pointer;
            user-select: none;
        }

        .tree-node-content {
            display: inline-block;
        }

        .tree-toggle {
            display: inline-block;
            width: 20px;
            cursor: pointer;
            color: #667eea;
            font-weight: bold;
        }

        .tree-key {
            color: #a626a4;
            font-weight: bold;
        }

        .tree-value {
            color: #50a14f;
        }

        .tree-string {
            color: #50a14f;
        }

        .tree-number {
            color: #986801;
        }

        .tree-boolean {
            color: #0184bc;
        }

        .tree-null {
            color: #a0a1a7;
        }

        .tree-count {
            color: #6c757d;
            font-style: italic;
            margin-left: 5px;
        }

        .tree-size {
            color: #dc3545;
            font-weight: bold;
            margin-left: 10px;
        }

        .tree-children {
            margin-left: 25px;
        }

        .tree-children.collapsed {
            display: none;
        }

        .highlight {
            background-color: yellow;
            font-weight: bold;
        }

        .search-box {
            width: 100%;
            padding: 12px;
            border: 2px solid #dee2e6;
            border-radius: 8px;
            margin-bottom: 15px;
            font-size: 14px;
        }

        .search-box:focus {
            outline: none;
            border-color: #667eea;
        }

        .diff-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .diff-panel {
            background: #f8f9fa;
            border: 2px solid #dee2e6;
            border-radius: 8px;
            padding: 15px;
            max-height: 600px;
            overflow: auto;
        }

        .diff-panel h3 {
            margin-bottom: 15px;
            color: #495057;
        }

        .diff-added {
            background-color: #d4edda;
            border-left: 4px solid #28a745;
            padding: 8px;
            margin: 4px 0;
        }

        .diff-removed {
            background-color: #f8d7da;
            border-left: 4px solid #dc3545;
            padding: 8px;
            margin: 4px 0;
        }

        .diff-modified {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 8px;
            margin: 4px 0;
        }

        .error-message {
            background: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #f5c6cb;
            margin: 15px 0;
        }

        .success-message {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #c3e6cb;
            margin: 15px 0;
        }

        .info-message {
            background: #d1ecf1;
            color: #0c5460;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #bee5eb;
            margin: 15px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🛠️ JSON Toolbox</h1>
            <p>Parser, Sizer, and Diff Tools for JSON Manipulation</p>
        </div>

        <div class="tabs">
            <button class="tab active" onclick="switchTab('parser', event)">Parser/Viewer</button>
            <button class="tab" onclick="switchTab('sizer', event)">Sizer Helper</button>
            <button class="tab" onclick="switchTab('diff', event)">Diff Tool</button>
        </div>

        <div class="content">
            <!-- Parser/Viewer Tool -->
            <div id="parser" class="tool-section active">
                <h2>Parser/Viewer Tool</h2>
                <div class="input-section">
                    <div class="input-group">
                        <label class="file-label">
                            📁 Upload JSON File
                            <input type="file" class="file-input" id="parserFileInput" accept=".json" onchange="loadFile('parser')">
                        </label>
                        <button class="btn btn-primary" onclick="processParser()">✨ Beautify & View</button>
                        <button class="btn btn-secondary" onclick="clearInput('parser')">🗑️ Clear</button>
                    </div>
                    <textarea id="parserInput" placeholder="Paste your JSON here..."></textarea>
                    <input type="text" id="parserSearch" class="search-box" placeholder="Search in JSON..." oninput="searchInTree('parser')">
                </div>
                <div class="output-section">
                    <div id="parserOutput" class="tree-view"></div>
                </div>
            </div>

            <!-- Sizer Helper Tool -->
            <div id="sizer" class="tool-section">
                <h2>Sizer Helper Tool</h2>
                <div class="input-section">
                    <div class="input-group">
                        <label class="file-label">
                            📁 Upload JSON File
                            <input type="file" class="file-input" id="sizerFileInput" accept=".json" onchange="loadFile('sizer')">
                        </label>
                        <button class="btn btn-primary" onclick="processSizer()">📊 Calculate Sizes</button>
                        <button class="btn btn-secondary" onclick="clearInput('sizer')">🗑️ Clear</button>
                    </div>
                    <textarea id="sizerInput" placeholder="Paste your JSON here..."></textarea>
                </div>
                <div class="output-section">
                    <div id="sizerOutput" class="tree-view"></div>
                </div>
            </div>

            <!-- Diff Tool -->
            <div id="diff" class="tool-section">
                <h2>Diff Tool</h2>
                <div class="input-section">
                    <h3>First JSON</h3>
                    <div class="input-group">
                        <label class="file-label">
                            📁 Upload JSON File
                            <input type="file" class="file-input" id="diff1FileInput" accept=".json" onchange="loadFile('diff1')">
                        </label>
                        <button class="btn btn-secondary" onclick="clearInput('diff1')">🗑️ Clear</button>
                    </div>
                    <textarea id="diff1Input" placeholder="Paste first JSON here..."></textarea>
                    
                    <h3 style="margin-top: 20px;">Second JSON</h3>
                    <div class="input-group">
                        <label class="file-label">
                            📁 Upload JSON File
                            <input type="file" class="file-input" id="diff2FileInput" accept=".json" onchange="loadFile('diff2')">
                        </label>
                        <button class="btn btn-secondary" onclick="clearInput('diff2')">🗑️ Clear</button>
                    </div>
                    <textarea id="diff2Input" placeholder="Paste second JSON here..."></textarea>
                    
                    <div class="input-group" style="margin-top: 20px;">
                        <button class="btn btn-primary" onclick="processDiff()">🔍 Compare JSONs</button>
                    </div>
                </div>
                <div class="output-section">
                    <div id="diffOutput"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Global variables for storing parsed data
        let parserData = null;
        let sizerData = null;
        let searchMatches = [];

        // Switch between tabs
        function switchTab(tabName, event) {
            // Hide all tool sections
            document.querySelectorAll('.tool-section').forEach(section => {
                section.classList.remove('active');
            });
            
            // Remove active class from all tabs
            document.querySelectorAll('.tab').forEach(tab => {
                tab.classList.remove('active');
            });
            
            // Show selected tool section
            document.getElementById(tabName).classList.add('active');
            
            // Add active class to selected tab
            event.target.classList.add('active');
        }

        // Load file content
        function loadFile(toolName) {
            const fileInput = document.getElementById(toolName + 'FileInput');
            const file = fileInput.files[0];
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById(toolName + 'Input').value = e.target.result;
                };
                reader.readAsText(file);
            }
        }

        // Clear input
        function clearInput(toolName) {
            document.getElementById(toolName + 'Input').value = '';
            if (toolName === 'parser') {
                document.getElementById('parserOutput').innerHTML = '';
                document.getElementById('parserSearch').value = '';
                parserData = null;
            } else if (toolName === 'sizer') {
                document.getElementById('sizerOutput').innerHTML = '';
                sizerData = null;
            } else if (toolName === 'diff1' || toolName === 'diff2') {
                // Don't clear output for diff, only the input
            }
        }

        // Calculate byte size of a string
        function getByteSize(str) {
            return new Blob([str]).size;
        }

        // Process Parser/Viewer
        function processParser() {
            const input = document.getElementById('parserInput').value.trim();
            const output = document.getElementById('parserOutput');
            
            if (!input) {
                output.innerHTML = '<div class="error-message">Please provide JSON input</div>';
                return;
            }
            
            try {
                parserData = JSON.parse(input);
                output.innerHTML = buildTreeView(parserData, '', false);
            } catch (e) {
                output.innerHTML = '<div class="error-message">Invalid JSON: ' + e.message + '</div>';
            }
        }

        // Build tree view for parser
        function buildTreeView(data, path, showSize) {
            let html = '<div class="tree-view-content">';
            html += buildTreeNode(data, '', path, 0, showSize);
            html += '</div>';
            return html;
        }

        // Build a single tree node
        function buildTreeNode(data, key, path, level, showSize) {
            const currentPath = path ? path + '.' + key : key;
            let html = '';
            
            if (data === null) {
                html += '<div class="tree-node" style="margin-left: ' + (level * 25) + 'px;">';
                if (key) html += '<span class="tree-key">"' + key + '"</span>: ';
                html += '<span class="tree-null">null</span>';
                if (showSize) {
                    html += '<span class="tree-size">' + getByteSize('null') + ' bytes</span>';
                }
                html += '</div>';
            } else if (typeof data === 'object') {
                const isArray = Array.isArray(data);
                const entries = isArray ? data : Object.entries(data);
                const count = isArray ? data.length : Object.keys(data).length;
                const nodeId = 'node-' + Math.random().toString(36).substring(2, 11);
                
                html += '<div class="tree-node" style="margin-left: ' + (level * 25) + 'px;">';
                html += '<span class="tree-toggle" onclick="toggleNode(\'' + nodeId + '\', event)">▼</span>';
                if (key) html += '<span class="tree-key">"' + key + '"</span>: ';
                html += '<span class="tree-value">' + (isArray ? '[' : '{') + '</span>';
                html += '<span class="tree-count">' + count + ' ' + (isArray ? 'items' : 'properties') + '</span>';
                
                if (showSize) {
                    const size = getByteSize(JSON.stringify(data));
                    html += '<span class="tree-size">' + size + ' bytes</span>';
                }
                
                html += '</div>';
                
                html += '<div id="' + nodeId + '" class="tree-children">';
                if (isArray) {
                    data.forEach((item, index) => {
                        html += buildTreeNode(item, '[' + index + ']', currentPath, level + 1, showSize);
                    });
                } else {
                    Object.entries(data).forEach(([k, v]) => {
                        html += buildTreeNode(v, k, currentPath, level + 1, showSize);
                    });
                }
                html += '</div>';
                
                html += '<div class="tree-node" style="margin-left: ' + (level * 25) + 'px;">';
                html += '<span class="tree-value">' + (isArray ? ']' : '}') + '</span>';
                html += '</div>';
            } else if (typeof data === 'string') {
                html += '<div class="tree-node" style="margin-left: ' + (level * 25) + 'px;">';
                if (key) html += '<span class="tree-key">"' + key + '"</span>: ';
                html += '<span class="tree-string">"' + escapeHtml(data) + '"</span>';
                if (showSize) {
                    html += '<span class="tree-size">' + getByteSize('"' + data + '"') + ' bytes</span>';
                }
                html += '</div>';
            } else if (typeof data === 'number') {
                html += '<div class="tree-node" style="margin-left: ' + (level * 25) + 'px;">';
                if (key) html += '<span class="tree-key">"' + key + '"</span>: ';
                html += '<span class="tree-number">' + data + '</span>';
                if (showSize) {
                    html += '<span class="tree-size">' + getByteSize(data.toString()) + ' bytes</span>';
                }
                html += '</div>';
            } else if (typeof data === 'boolean') {
                html += '<div class="tree-node" style="margin-left: ' + (level * 25) + 'px;">';
                if (key) html += '<span class="tree-key">"' + key + '"</span>: ';
                html += '<span class="tree-boolean">' + data + '</span>';
                if (showSize) {
                    html += '<span class="tree-size">' + getByteSize(data.toString()) + ' bytes</span>';
                }
                html += '</div>';
            }
            
            return html;
        }

        // Toggle tree node
        function toggleNode(nodeId, event) {
            const node = document.getElementById(nodeId);
            const toggle = event.target;
            
            if (node.classList.contains('collapsed')) {
                node.classList.remove('collapsed');
                toggle.textContent = '▼';
            } else {
                node.classList.add('collapsed');
                toggle.textContent = '▶';
            }
        }

        // Search in tree
        function searchInTree(toolName) {
            const searchTerm = document.getElementById(toolName + 'Search').value.toLowerCase();
            
            if (toolName === 'parser') {
                if (!parserData) return;
                
                // Re-render tree with search highlighting
                const output = document.getElementById('parserOutput');
                output.innerHTML = buildTreeViewWithSearch(parserData, searchTerm);
            }
        }

        // Build tree view with search highlighting
        function buildTreeViewWithSearch(data, searchTerm) {
            let html = '<div class="tree-view-content">';
            html += buildTreeNodeWithSearch(data, '', '', 0, searchTerm);
            html += '</div>';
            return html;
        }

        // Build tree node with search highlighting
        function buildTreeNodeWithSearch(data, key, path, level, searchTerm) {
            const currentPath = path ? path + '.' + key : key;
            let html = '';
            
            if (data === null) {
                html += '<div class="tree-node" style="margin-left: ' + (level * 25) + 'px;">';
                if (key) {
                    html += '<span class="tree-key">"' + highlightText(key, searchTerm) + '"</span>: ';
                }
                html += '<span class="tree-null">null</span>';
                html += '</div>';
            } else if (typeof data === 'object') {
                const isArray = Array.isArray(data);
                const entries = isArray ? data : Object.entries(data);
                const count = isArray ? data.length : Object.keys(data).length;
                const nodeId = 'node-' + Math.random().toString(36).substring(2, 11);
                
                // Check if this node or any children match the search
                const hasMatch = searchInObject(data, searchTerm) || (key && key.toLowerCase().includes(searchTerm));
                
                html += '<div class="tree-node" style="margin-left: ' + (level * 25) + 'px;">';
                html += '<span class="tree-toggle" onclick="toggleNode(\'' + nodeId + '\', event)">▼</span>';
                if (key) {
                    html += '<span class="tree-key">"' + highlightText(key, searchTerm) + '"</span>: ';
                }
                html += '<span class="tree-value">' + (isArray ? '[' : '{') + '</span>';
                html += '<span class="tree-count">' + count + ' ' + (isArray ? 'items' : 'properties') + '</span>';
                html += '</div>';
                
                html += '<div id="' + nodeId + '" class="tree-children' + (hasMatch && searchTerm ? '' : '') + '">';
                if (isArray) {
                    data.forEach((item, index) => {
                        html += buildTreeNodeWithSearch(item, '[' + index + ']', currentPath, level + 1, searchTerm);
                    });
                } else {
                    Object.entries(data).forEach(([k, v]) => {
                        html += buildTreeNodeWithSearch(v, k, currentPath, level + 1, searchTerm);
                    });
                }
                html += '</div>';
                
                html += '<div class="tree-node" style="margin-left: ' + (level * 25) + 'px;">';
                html += '<span class="tree-value">' + (isArray ? ']' : '}') + '</span>';
                html += '</div>';
            } else if (typeof data === 'string') {
                html += '<div class="tree-node" style="margin-left: ' + (level * 25) + 'px;">';
                if (key) {
                    html += '<span class="tree-key">"' + highlightText(key, searchTerm) + '"</span>: ';
                }
                html += '<span class="tree-string">"' + highlightText(escapeHtml(data), searchTerm) + '"</span>';
                html += '</div>';
            } else if (typeof data === 'number') {
                html += '<div class="tree-node" style="margin-left: ' + (level * 25) + 'px;">';
                if (key) {
                    html += '<span class="tree-key">"' + highlightText(key, searchTerm) + '"</span>: ';
                }
                html += '<span class="tree-number">' + highlightText(data.toString(), searchTerm) + '</span>';
                html += '</div>';
            } else if (typeof data === 'boolean') {
                html += '<div class="tree-node" style="margin-left: ' + (level * 25) + 'px;">';
                if (key) {
                    html += '<span class="tree-key">"' + highlightText(key, searchTerm) + '"</span>: ';
                }
                html += '<span class="tree-boolean">' + highlightText(data.toString(), searchTerm) + '</span>';
                html += '</div>';
            }
            
            return html;
        }

        // Highlight matching text
        function highlightText(text, searchTerm) {
            if (!searchTerm) return text;
            
            const regex = new RegExp('(' + escapeRegex(searchTerm) + ')', 'gi');
            return text.replace(regex, '<span class="highlight">$1</span>');
        }

        // Check if object contains search term
        function searchInObject(obj, searchTerm) {
            if (!searchTerm) return false;
            
            if (typeof obj === 'string') {
                return obj.toLowerCase().includes(searchTerm);
            } else if (typeof obj === 'number' || typeof obj === 'boolean') {
                return obj.toString().toLowerCase().includes(searchTerm);
            } else if (Array.isArray(obj)) {
                return obj.some(item => searchInObject(item, searchTerm));
            } else if (typeof obj === 'object' && obj !== null) {
                return Object.entries(obj).some(([key, value]) => 
                    key.toLowerCase().includes(searchTerm) || searchInObject(value, searchTerm)
                );
            }
            
            return false;
        }

        // Escape HTML
        function escapeHtml(text) {
            const div = document.createElement('div');
            div.textContent = text;
            return div.innerHTML;
        }

        // Escape regex special characters
        function escapeRegex(text) {
            return text.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
        }

        // Process Sizer Helper
        function processSizer() {
            const input = document.getElementById('sizerInput').value.trim();
            const output = document.getElementById('sizerOutput');
            
            if (!input) {
                output.innerHTML = '<div class="error-message">Please provide JSON input</div>';
                return;
            }
            
            try {
                sizerData = JSON.parse(input);
                output.innerHTML = buildTreeView(sizerData, '', true);
                
                // Add total size info
                const totalSize = getByteSize(input);
                output.innerHTML = '<div class="info-message">Total JSON size: <strong>' + totalSize + ' bytes</strong> (' + (totalSize / 1024).toFixed(2) + ' KB)</div>' + output.innerHTML;
            } catch (e) {
                output.innerHTML = '<div class="error-message">Invalid JSON: ' + e.message + '</div>';
            }
        }

        // Process Diff Tool
        function processDiff() {
            const input1 = document.getElementById('diff1Input').value.trim();
            const input2 = document.getElementById('diff2Input').value.trim();
            const output = document.getElementById('diffOutput');
            
            if (!input1 || !input2) {
                output.innerHTML = '<div class="error-message">Please provide both JSON inputs</div>';
                return;
            }
            
            try {
                const json1 = JSON.parse(input1);
                const json2 = JSON.parse(input2);
                
                const diff = compareJSON(json1, json2);
                output.innerHTML = buildDiffView(diff);
            } catch (e) {
                output.innerHTML = '<div class="error-message">Invalid JSON: ' + e.message + '</div>';
            }
        }

        // Compare two JSON objects
        function compareJSON(obj1, obj2, path = '') {
            const differences = {
                onlyInFirst: [],
                onlyInSecond: [],
                different: []
            };
            
            // Check obj1 keys
            if (typeof obj1 === 'object' && obj1 !== null && typeof obj2 === 'object' && obj2 !== null) {
                const keys1 = Array.isArray(obj1) ? obj1.map((_, i) => i.toString()) : Object.keys(obj1);
                const keys2 = Array.isArray(obj2) ? obj2.map((_, i) => i.toString()) : Object.keys(obj2);
                
                // Find keys only in first object
                keys1.forEach(key => {
                    const currentPath = path ? path + '.' + key : key;
                    
                    if (Array.isArray(obj2) ? (parseInt(key) >= obj2.length) : !(key in obj2)) {
                        differences.onlyInFirst.push({
                            path: currentPath,
                            value: obj1[key]
                        });
                    } else {
                        // Key exists in both, compare values
                        const val1 = obj1[key];
                        const val2 = obj2[key];
                        
                        if (typeof val1 === 'object' && val1 !== null && typeof val2 === 'object' && val2 !== null) {
                            // Recursively compare objects
                            const nestedDiff = compareJSON(val1, val2, currentPath);
                            differences.onlyInFirst.push(...nestedDiff.onlyInFirst);
                            differences.onlyInSecond.push(...nestedDiff.onlyInSecond);
                            differences.different.push(...nestedDiff.different);
                        } else if (JSON.stringify(val1) !== JSON.stringify(val2)) {
                            differences.different.push({
                                path: currentPath,
                                value1: val1,
                                value2: val2
                            });
                        }
                    }
                });
                
                // Find keys only in second object
                keys2.forEach(key => {
                    const currentPath = path ? path + '.' + key : key;
                    
                    if (Array.isArray(obj1) ? (parseInt(key) >= obj1.length) : !(key in obj1)) {
                        differences.onlyInSecond.push({
                            path: currentPath,
                            value: obj2[key]
                        });
                    }
                });
            } else if (JSON.stringify(obj1) !== JSON.stringify(obj2)) {
                differences.different.push({
                    path: path || 'root',
                    value1: obj1,
                    value2: obj2
                });
            }
            
            return differences;
        }

        // Build diff view
        function buildDiffView(diff) {
            let html = '';
            
            if (diff.onlyInFirst.length === 0 && diff.onlyInSecond.length === 0 && diff.different.length === 0) {
                return '<div class="success-message">✓ Both JSON objects are identical!</div>';
            }
            
            html += '<div class="diff-container">';
            
            // Left panel - Missing in second
            html += '<div class="diff-panel">';
            html += '<h3>Missing in Second JSON (Present only in First)</h3>';
            if (diff.onlyInFirst.length > 0) {
                diff.onlyInFirst.forEach(item => {
                    html += '<div class="diff-removed">';
                    html += '<strong>' + escapeHtml(item.path) + '</strong>: ';
                    html += '<span>' + escapeHtml(JSON.stringify(item.value, null, 2)) + '</span>';
                    html += '</div>';
                });
            } else {
                html += '<div class="info-message">No missing elements</div>';
            }
            html += '</div>';
            
            // Right panel - Missing in first
            html += '<div class="diff-panel">';
            html += '<h3>Missing in First JSON (Present only in Second)</h3>';
            if (diff.onlyInSecond.length > 0) {
                diff.onlyInSecond.forEach(item => {
                    html += '<div class="diff-added">';
                    html += '<strong>' + escapeHtml(item.path) + '</strong>: ';
                    html += '<span>' + escapeHtml(JSON.stringify(item.value, null, 2)) + '</span>';
                    html += '</div>';
                });
            } else {
                html += '<div class="info-message">No missing elements</div>';
            }
            html += '</div>';
            
            html += '</div>';
            
            // Different values section
            if (diff.different.length > 0) {
                html += '<div style="margin-top: 20px;">';
                html += '<h3>Different Values</h3>';
                html += '<div class="diff-panel">';
                diff.different.forEach(item => {
                    html += '<div class="diff-modified">';
                    html += '<strong>' + escapeHtml(item.path) + '</strong><br>';
                    html += '<span style="color: #dc3545;">First: ' + escapeHtml(JSON.stringify(item.value1, null, 2)) + '</span><br>';
                    html += '<span style="color: #28a745;">Second: ' + escapeHtml(JSON.stringify(item.value2, null, 2)) + '</span>';
                    html += '</div>';
                });
                html += '</div>';
                html += '</div>';
            }
            
            return html;
        }
    </script>
</body>
</html>
