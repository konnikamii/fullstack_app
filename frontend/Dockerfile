FROM node:22
 
# Set working directory
WORKDIR /app

# this will allow us to run vite and other tools directly
ENV PATH /app/node_modules/.bin:$PATH

# Install dependencies
COPY package*.json ./

# Remove cached or broken node_modules if they exist
RUN rm -rf node_modules package-lock.json
  
# Install dependencies
RUN npm install

# Copy project files
COPY . .

# Expose port and start the application
EXPOSE 3000
CMD ["npm", "run", "dev", "--host"]